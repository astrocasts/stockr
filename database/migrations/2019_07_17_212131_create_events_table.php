<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('event_id');
            $table->string('event_type'); // class name of the message
            $table->string('aggregate_root_type'); // class name of the aggregate root: eg. Item
            $table->uuid('aggregate_root_id');
            $table->bigInteger('aggregate_root_version');
            $table->timestampTz('recorded_at');
            $table->jsonb('payload');

            $table->unique(['aggregate_root_id', 'aggregate_root_version']); // optimistic concurrency

            // Projection Critera fields
            // stream_id => aggregate_root_id
            // stream_version => aggregate_root_version
            // category => aggregate_root_type
            // event_type => event_type
            // event_id => event_id
            // partition => XXX
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
