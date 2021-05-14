<?php

/* Swagger documentation */
/**
 * @OA\Info(title="Introduction to Web Programming Project", version="0.1")
 * @OA\OpenApi(
 *    @OA\Server(url="http://localhost/webprogramming/", description="Development Environment" ),
 *    @OA\SecurityScheme(securityScheme="ApiKeyAuth", type="apiKey", in="header", name="Authentication" )
 *)
 */


 /**
  * @OA\Get(path="/jobs",
  *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
  *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
  *     @OA\Parameter(type="string", in="query", name="search", description="Search string for products. Case insensitive search."),
  *     @OA\Response(response="200", description="List jobs from database")
  * )
  */
Flight::route('GET /jobs', function(){
    $offset = Flight::query("offset", 0);
    $limit = Flight::query("limit", 30);
    $search = Flight::query("search");
    Flight::json(Flight::jobService()->getJobs($search, $offset, $limit));
});

/**
 * @OA\Get(path="/jobs/{id}",
 *     @OA\Parameter(type="integer", name="id", default=1, description="ID of a job from database"),
 *     @OA\Response(response="200", description="Get a job from database")
 * )
 */
Flight::route('GET /jobs/@id', function($id){
    $jobService = new JobService();
    $job = $jobService->getById($id);
    Flight::json($job);
});

/**
 * @OA\Post(path="/jobs",
 *     @OA\Response(response="200", description="Add a job to database")
 * )
 */
Flight::route('POST /jobs', function(){
    $job = Flight::jobService()->addJob(Flight::request()->data->getData());
    Flight::json($job);
});

/**
 * @OA\Put(path="/jobs/{id}",
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", allowReserved=true, name="id", example=1),
 *     @OA\Response(response="200", description="Update a job in the database")
 * )
 */
Flight::route('PUT /jobs/@id', function($id){
    $job = Flight::jobService()->update($id, Flight::request()->data->getData());
    Flight::json($job);
});
