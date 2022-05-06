<?php

namespace App\Http\Controllers;

use App\Dtos\RepositoryStatisticsDto;
use App\Exceptions\RepositoryNotExistsException;
use App\Storages\Contract\RepositoryEntityStorageInterface;
use App\Services\RepositoryComparisonStatisticInterface;
use App\ValidationRules\GithubStatisticsRequestValidationRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class GithubRepositoryStatisticController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        private readonly RepositoryEntityStorageInterface $storage,
        private readonly RepositoryComparisonStatisticInterface $repositoryComparisonStatistic,
    ) {
        //
    }

    /**
     * @param  Request  $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function getRepositoryStatistics(Request $request): JsonResponse
    {
        $this->validate(
            $request,
            GithubStatisticsRequestValidationRule::getRules()
        );

        $requestedRepositories = $request->get('repositories');
        $repositories          = new Collection();
        $notFoundRepositories  = new Collection();


        foreach ($requestedRepositories as $requestedRepository) {
            try {
                $repositoryEntity = $this->storage->get($requestedRepository['identifier']);

                $repositories->push($repositoryEntity);
            } catch (RepositoryNotExistsException $e) {
                if (count($requestedRepository) === 2) {
                    return response()->json([
                        'message' => $e->getMessage()
                    ], Response::HTTP_NOT_FOUND);
                }

                $notFoundRepositories->push($requestedRepository['identifier']);
            } catch (\Throwable $e) {
                return response()->json([
                    'message' => 'Something went wrong. Please try later!'
                ],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
        }

        $dto = RepositoryStatisticsDto::fromEntity(
            $this->repositoryComparisonStatistic->compareRepositories(
                $repositories
            )
        );

        $responseContext = ['statistics' => $dto];

        if ($notFoundRepositories->count() > 0) {
            $responseContext['not_found_repositories'] = $notFoundRepositories;
        }

        return response()->json($responseContext);
    }
}
