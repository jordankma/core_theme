<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateContestSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('contest_setting', function (Blueprint $table) {

        });
        DB::connection('mongodb')->table('contest_setting')->insert(
            array(
                [
                    'name' => 'Điều kiện vòng thi',
                    'param' => 'round_condition',
                    'data_type' => 'array',
                    'data' => array(
                        [
                            'key' => 1,
                            'value' => 'Độc lập'
                        ],
                        [
                            'key' => 2,
                            'value' => 'Phụ thuộc, chỉ cần đã thi vòng trước',
                        ],
                        [
                            'key' => 3,
                            'value' => 'Phụ thuộc, yêu cầu hoàn thành vòng trước',
                        ],
                        [
                            'key' => 4,
                            'value' => 'Phụ thuộc, theo điều kiện của cuộc thi'
                        ],
                    )
                ],
                [
                    'name' => 'Điều kiện thi tuần tiếp theo',
                    'param' => 'topic_condition',
                    'data_type' => 'array',
                    'data' => array(
                        [
                            'key' => 1,
                            'value' => 'Yêu cầu phải thi đủ các tuần thi trước đó'
                        ],
                        [
                            'key' => 2,
                            'value' => 'Yêu cầu phải thi 1 trong các tuần thi trước đó',
                        ],
                        [
                            'key' => 3,
                            'value' => 'Không có ràng buộc'
                        ],
                    )
                ],
                [
                    'name' => 'Cách tính điểm tuần thi',
                    'param' => 'topic_point_method',
                    'data_type' => 'array',
                    'data' => array(
                        [
                            'key' => 1,
                            'value' => 'Tổng điểm và thời gian các lượt thi trong tuần'
                        ],
                        [
                            'key' => 2,
                            'value' => 'Lấy kết quả có điểm thi cao nhất trong tuần',
                        ],
                        [
                            'key' => 3,
                            'value' => 'Lấy điểm và thời gian thi trung bình trong tuần'
                        ],
                    )
                ],
                [
                    'name' => 'Cách tính điểm vòng thi',
                    'param' => 'round_point_method',
                    'data_type' => 'array',
                    'data' => array(
                        [
                            'key' => 1,
                            'value' => 'Tổng điểm và thời gian các tuần thi trong vòng'
                        ],
                        [
                            'key' => 2,
                            'value' => 'Lấy tuần thi có điểm thi cao nhất trong vòng',
                        ],
                        [
                            'key' => 3,
                            'value' => 'Lấy điểm và thời gian thi trung bình trong vòng'
                        ],
                    )
                ],
                [
                    'name' => 'Môi trường Client',
                    'param' => 'environment',
                    'data_type' => 'array',
                    'data' => array(
                        [
                            'key' => 'cocos',
                            'value' => 'Cocos'
                        ],
                        [
                            'key' => 'vuejs',
                            'value' => 'VueJs',
                        ]
                    )
                ],
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mongodb')->dropIfExists('contest_setting');
    }
}
