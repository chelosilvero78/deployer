<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use App\Repositories\Contracts\TemplateRepositoryInterface;
use Lang;

/**
 * The controller for managging projects.
 */
class ProjectController extends Controller
{
    /**
     * The project repository.
     *
     * @var ProjectRepositoryInterface
     */
    private $projectRepository;

    /**
     * Class constructor.
     *
     * @param  ProjectRepositoryInterface $projectRepository
     * @return void
     */
    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * Shows all projects.
     *
     * @param  TemplateRepositoryInterface $templateRepository
     * @return Response
     */
    public function index(TemplateRepositoryInterface $templateRepository)
    {
        $projects = $this->projectRepository->getAll();

        return view('admin.projects.listing', [
            'title'     => Lang::get('projects.manage'),
            'templates' => $templateRepository->getAll(),
            'projects'  => $projects->toJson(), // Because PresentableInterface toJson() is not working in the view
        ]);
    }

    /**
     * Store a newly created project in storage.
     *
     * @param  StoreProjectRequest $request
     * @return Response
     */
    public function store(StoreProjectRequest $request)
    {
        return $this->projectRepository->create($request->only(
            'name',
            'repository',
            'branch',
            'group_id',
            'builds_to_keep',
            'url',
            'build_url',
            'template_id'
        ));
    }

    /**
     * Update the specified project in storage.
     *
     * @param  int                 $project_id
     * @param  StoreProjectRequest $request
     * @return Response
     */
    public function update($project_id, StoreProjectRequest $request)
    {
        return $this->projectRepository->updateById($request->only(
            'name',
            'repository',
            'branch',
            'group_id',
            'builds_to_keep',
            'url',
            'build_url'
        ), $project_id);
    }

    /**
     * Remove the specified project from storage.
     *
     * @param  int      $project_id
     * @return Response
     */
    public function destroy($project_id)
    {
        $this->projectRepository->deleteById($project_id);

        return [
            'success' => true,
        ];
    }
}
