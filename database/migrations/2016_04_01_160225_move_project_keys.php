<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use REBELinBLUE\Deployer\Key;
use REBELinBLUE\Deployer\Project;

class MoveProjectKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedInteger('key_id')->nullable();
            $table->foreign('key_id')->references('id')->on('keys');
        });

        $projects = Project::withTrashed()->get();

        foreach ($projects as $project) {
            $key = Key::create([
                'name'        => $project->name,
                'private_key' => $project->private_key,
                'public_key'  => $project->public_key,
            ]);

            $project->key_id = $key->id;
            $project->save();
        }

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('private_key');
            $table->dropColumn('public_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
