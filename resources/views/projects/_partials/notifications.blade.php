<div class="box">
    <div class="box-header">
        <div class="pull-right">
            <button type="button" class="btn btn-default" title="{{ Lang::get('channels.create') }}" data-toggle="modal" data-target="#notification"><span class="fa fa-plus"></span> {{ Lang::get('channels.create') }}</button>
        </div>
        <h3 class="box-title">{{ Lang::get('channels.label') }}</h3>
    </div>

    <div class="box-body" id="no_notifications">
        <p>{{ Lang::get('channels.none') }}</p>
    </div>

    <div class="box-body table-responsive">
        <table class="table table-striped" id="notification_list">
            <thead>
                <tr>
                    <th>{{ Lang::get('channels.name') }}</th>
                    <th>{{ Lang::get('channels.type') }}</th>
                    <th class="text-center">{{ Lang::get('channels.on_deployment_success') }}</th>
                    <th class="text-center">{{ Lang::get('channels.on_deployment_failure') }}</th>
                    <th class="text-center">{{ Lang::get('channels.on_link_down') }}</th>
                    <th class="text-center">{{ Lang::get('channels.on_link_recovered') }}</th>
                    <th class="text-center">{{ Lang::get('channels.on_heartbeat_missing') }}</th>
                    <th class="text-center">{{ Lang::get('channels.on_heartbeat_recovered') }}</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

@push('templates')
    <script type="text/template" id="notification-template">
        <td><%- name %></td>
        <td><span class="fa fa-<%- icon %>"></span> <%- label %></td>
        <td class="text-center"><% if (on_deployment_success) { %><i class="fa fa-check"></i><% } %></td>
        <td class="text-center"><% if (on_deployment_failure) { %><i class="fa fa-check"></i><% } %></td>
        <td class="text-center"><% if (on_link_down) { %><i class="fa fa-check"></i><% } %></td>
        <td class="text-center"><% if (on_link_recovered) { %><i class="fa fa-check"></i><% } %></td>
        <td class="text-center"><% if (on_heartbeat_missing) { %><i class="fa fa-check"></i><% } %></td>
        <td class="text-center"><% if (on_heartbeat_recovered) { %><i class="fa fa-check"></i><% } %></td>
        <td>
            <div class="btn-group pull-right">
                <button type="button" class="btn btn-default btn-edit" title="{{ Lang::get('channels.edit') }}" data-toggle="modal" data-backdrop="static" data-target="#notification"><i class="fa fa-edit"></i></button>
            </div>
        </td>
    </script>
@endpush
