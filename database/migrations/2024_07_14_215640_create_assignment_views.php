<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE VIEW v_report_assignment AS SELECT
        `a`.`id` AS `id`,
        `a`.`id_assignment` AS `id_assignment`,
        `c`.`title` AS `assignment_title`,
        `b`.`nama_lengkap` AS `nama_lengkap`,
        `b`.`kabupaten_ket` AS `kabupaten_ket`,
        `b`.`provinsi_ket` AS `provinsi_ket`,
        `a`.`result` AS `result`
        FROM
        (((`t_assignment_master` `a` join `m_user` `b` on((`a`.`id_user` = `b`.`id`))) 
            join `assignment` `c` on((`a`.`id_assignment` = `c`.`id`)))) where (`a`.`result` is not null)
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignment_views');
    }
}
