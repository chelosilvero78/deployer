<?php

namespace REBELinBLUE\Deployer\Http\Controllers\Resources;

use REBELinBLUE\Deployer\Contracts\Repositories\ChannelRepositoryInterface;
use REBELinBLUE\Deployer\Http\Requests\StoreChannelRequest;

/**
 * Controller for managing notifications.
 */
class ChannelController extends ResourceController
{
    /**
     * NotificationController constructor.
     *
     * @param ChannelRepositoryInterface $repository
     */
    public function __construct(ChannelRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created notification in storage.
     *
     * @param StoreChannelRequest $request
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(StoreChannelRequest $request)
    {
        return $this->repository->create($request->only(
            'name',
            'project_id',
//            'channel',
//            'webhook',
//            'icon',
//            'failure_only'
        ));
    }

    /**
     * Update the specified notification in storage.
     *
     * @param $channel_id
     * @param StoreChannelRequest $request
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($channel_id, StoreChannelRequest $request)
    {
        return $this->repository->updateById($request->only(
            'name',
//            'channel',
//            'webhook',
//            'icon',
//            'failure_only'
        ), $channel_id);
    }
}
