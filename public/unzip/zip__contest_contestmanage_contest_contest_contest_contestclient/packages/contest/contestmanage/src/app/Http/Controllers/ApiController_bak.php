<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Adtech\Application\Cms\Controllers\Controller as Controller;
use Contest\Contestmanage\App\Models\ContestRound;
use Contest\Contestmanage\App\Models\ContestTopic;
use Contest\Contestmanage\App\Models\UserContestInfo;
use Contest\Contestmanage\App\Repositories\ContestRoundRepository;
use Contest\Contestmanage\App\Repositories\ContestSeasonRepository;
use Contest\Contestmanage\App\Repositories\ContestTopicRepository;
use Contest\Contestmanage\App\Repositories\TopicRoundRepository;
use Illuminate\Http\Request;
use Validator;
use Yajra\Datatables\Datatables;

class ApiController extends Controller
{
    public function __construct(ContestSeasonRepository $seasonRepository, ContestRoundRepository $roundRepository, ContestTopicRepository $topicRepository, TopicRoundRepository $topicRoundRepository)
    {
        parent::__construct();
        $this->season = $seasonRepository;
        $this->round = $roundRepository;
        $this->topic = $topicRepository;
        $this->topic_round = $topicRoundRepository;
    }

    public function getListData(Request $request)
    {
        $data_view = [
            'type' => $request->type,
            'title' => ''
        ];
        $html = view('CONTEST-CONTESTMANAGE::modules.contestmanage.includes.get_list_data', $data_view)->render();
        return response()->json($html);
    }

    //Table Data to index page
    public function data(Request $request)
    {
        if (!empty($request->type)) {
            switch ($request->type) {
                case 'season':
                    return Datatables::of($this->season->findAll())
                        ->addColumn('actions', function ($season) {
                            $actions = '<a href="javascript:void(0)" c-data="' . $season->name . '" data-value="' . $season->season_id . '" class="season_choose"><i class="livicon" data-name="plus" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="chọn"></i></a>';
                            return $actions;
                        })
                        ->rawColumns(['actions'])
                        ->make();
                    break;
                case 'round':
                    return Datatables::of($this->round->findAll())
                        ->addColumn('actions', function ($round) {
                            $actions = '<a href="javascript:void(0)" c-data="' . $round->display_name . '" data-value="' . $round->round_id . '" class="round_choose"><i class="livicon" data-name="plus" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="chọn"></i></a>';
                            return $actions;
                        })
                        ->rawColumns(['actions'])
                        ->make();
                    break;
                case 'topic':
                    return Datatables::of($this->topic->findAll())
                        ->addColumn('actions', function ($topic) {
                            $actions = '<a href="javascript:void(0)" c-data="' . $topic->display_name . '" data-value="' . $topic->topic_id . '" class="topic_choose"><i class="livicon" data-name="plus" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="chọn"></i></a>';
                            return $actions;
                        })
                        ->rawColumns(['actions'])
                        ->make();
                    break;
                case 'topic_round':
                    return Datatables::of($this->topic_round->findAll())
                        ->addColumn('actions', function ($topic_round) {
                            $actions = '<a href="javascript:void(0)" c-data="' . $topic_round->display_name . '" data-value="' . $topic_round->topic_round_id . '" class="choose"><i class="livicon" data-name="plus" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="chọn"></i></a>';
                            return $actions;
                        })
                        ->rawColumns(['actions'])
                        ->make();
                    break;

            }
        }

    }

    public function getExamInfo(Request $request)
    {
        if (!empty($request->type)) {
            $arr = [];
            $arr['round'] = [];
            $round = ContestRound::query()->where('round_type', $request->type)->get();
            if (!empty($round)) {
                foreach ($round as $key => $item) {
                    $topic = ContestTopic::query()->where('round_id', $item->round_id)->get();
                    $start = \DateTime::createFromFormat('Y-m-d H:m:i', $item->start_date);
                    $start = $start->getTimestamp();
                    $end = \DateTime::createFromFormat('Y-m-d H:m:i', $item->end_date);
                    $end = $end->getTimestamp();
                    $arr['round'][$key] = [
                        "round_id" => 1,
                        "order" => 1,
                        "round_name" => $item->round_name,
                        "display_name" => $item->display_name,
                        "description" => $item->description,
                        "time" => [
                            "start" => $start,
                            "end" => $end,
                            "end_notify" => $item->end_notify
                        ],
                        "total_topic" => $topic->count(),
                        "topic" => []
                    ];
                    if (!empty($topic)) {
                        foreach ($topic as $key1 => $value1) {
                            $topic_start = \DateTime::createFromFormat('Y-m-d H:m:i', $value1->start_date);
                            $topic_start = $topic_start->getTimestamp();
                            $topic_end = \DateTime::createFromFormat('Y-m-d H:m:i', $value1->end_date);
                            $topic_end = $topic_end->getTimestamp();
                            $topic_round =  json_decode($value1->topic_round, true);
                            $topic_round_arr = [];
                            if(!empty($topic_round)){
                                    foreach ($topic_round as $key2=>$value2){
                                        $topic_round_arr[] = [
                                            'id' => $key2,
                                            'rule_text' => $value2['rule_text']
                                    ];
                                }

                            }
                            $arr['round'][$key]['topic'][$key1] = [
                                "topic_id" => $value1->topic_id,
                                "order" => $value1->order,
                                "topic_name" => $value1->topic_name,
                                "display_name" => $value1->display_name,
                                "topic_type" => $value1->type,
                                "type" => $value1->topic_type,
                                "rule_text" => $value1->rule_text,
                                "time" => [
                                    "start" => $topic_start,
                                    "end" => $topic_end,
                                    "end_notify" => $value1->end_notify
                                ],
                                "exam_repeat_time" => $value1->exam_repeat_time,
                                "exam_repeat_time_wait" => $value1->exam_repeat_time_wait,
                                "total_time_limit" => $value1->total_time_limit,
                                "question_pack_id" => $value1->question_pack_id,
                                "topic_round" => $topic_round_arr
                            ];
                        }
                    }
                }
            }
            $data = [
                'exam_info' => $arr
            ];
            return response()->json($data);
        }
    }

    public function getQuestTest()
    {
        $res = '{
              "dethi": {
                "id": 125,
                "key": 0,
                "time": 12,
                "type_of_exam": 1,
                "type_of_answer": 1,
                "background": "",
                "style_answer": [],
                "number_question": 30,
                "point": 200,
                "clone_id": 951
              },
              "list_round": [
                {
                  "round_id": 383,
                  "round_name": "Vòng 1",
                  "round_name_2": 1,
                  "number_question": 20,
                  "point": 100,
                  "listQuestRound": [
                    {
                      "id": 7149,
                      "q": "SGFpIHF14bqnbiDEkeG6o28gSG/DoG5nIFNhIHbDoCBUcsaw4budbmcgU2EgdGh14buZYyBjaOG7pyBxdXnhu4FuIGtow7RuZyB0aOG7gyB0cmFuaCBjw6NpIGPhu6dhIFZp4buHdCBOYW0gYuG7n2kgdsOsOg==",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 1,
                      "minuspoint": 0,
                      "idx_true": [
                        0
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "Vmnhu4d0IE5hbSBsw6AgcXXhu5FjIGdpYSDEkcOjIGNoaeG6v20gaOG7r3UgdGjhu7FjIHPhu7EgaGFpIHF14bqnbiDEkeG6o28gSG/DoG5nIFNhIHbDoCBUcsaw4budbmcgU2Ega2hpIGPDoWMgcXXhuqduIMSR4bqjbyDEkcOzIGNoxrBhIHRodeG7mWMgY2jhu6cgcXV54buBbiBj4bunYSBi4bqldCBj4bupIHF14buRYyBnaWEgbsOgby4="
                        },
                        {
                          "id": 1,
                          "text": "TmjDoCBuxrDhu5tjIFZp4buHdCBOYW0gKHThu6sgdGjhu51pIHBob25nIGtp4bq/biDEkeG6v24gbmF5KSBsdcO0biBi4bqjbyB24buHIHTDrWNoIGPhu7FjIGPDoWMgcXV54buBbiB2w6AgZGFuaCBuZ2jEqWEgY+G7p2EgbcOsbmggdHLGsOG7m2MgbeG7jWkgbcawdSDEkeG7kyB2w6AgaMOgbmggxJHhu5luZyB4w6JtIHBo4bqhbSB04bubaSBjaOG7pyBxdXnhu4FuLCB0b8OgbiB24bq5biBsw6NuaCB0aOG7lSB2w6AgcXV54buBbiBs4bujaSBj4bunYSBWaeG7h3QgTmFtIMSR4buRaSB24bubaSBoYWkgcXXhuqduIMSR4bqjbyBIb8OgbmcgU2EgdsOgIFRyxrDhu51uZyBTYS4="
                        },
                        {
                          "id": 2,
                          "text": "Q+G6oyAzIGzDvSBkbyBuw7NpIHRyw6puLg=="
                        },
                        {
                          "id": 3,
                          "text": "VOG7qyB0aOG6vyBr4bu3IFhWSUkgxJHhur9uIG5heSwgTmjDoCBuxrDhu5tjIFZp4buHdCBOYW0gxJHDoyB0aOG7sWMgaGnhu4duIG3hu5l0IGPDoWNoIHRo4buxYyBz4buxLCBsacOqbiB04bulYyB2w6AgaMOyYSBiw6xuaCBjaOG7pyBxdXnhu4FuIGPhu6dhIFZp4buHdCBOYW0gxJHhu5FpIHbhu5tpIGhhaSBxdeG6p24gxJHhuqNvIEhvw6BuZyBTYSB2w6AgVHLGsOG7nW5nIFNhLg=="
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7148,
                      "q": "xJDGoW4gduG7iyBuw6BvIGPhu6dhIFF1w6JuIGNo4bunbmcgSOG6o2kgUXXDom4gbMOgIMSRxqFuIHbhu4sgcGjhu5FpIGjhu6NwIHRo4buxYyBoaeG7h24gY8O0bmcgdMOhYyB0w6FjIHR1ecOqbiB0cnV54buBbiBiaeG7g24sIMSR4bqjbyB0csOqbiDEkeG6oWkgYsOgbiB04buJbmggxJDhuq9rIE7DtG5nPw==",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 2,
                      "minuspoint": 0,
                      "idx_true": [
                        2
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "SOG7jWMgVmnhu4duIEjhuqNpIFF1w6Ju"
                        },
                        {
                          "id": 1,
                          "text": "TOG7ryDEkW/DoG4gMTQ2"
                        },
                        {
                          "id": 2,
                          "text": "UXXDom4gY+G6o25nIFPDoGkgR8Oybg=="
                        },
                        {
                          "id": 3,
                          "text": "TOG7ryDEkW/DoG4gVMOgdSBuZ+G6p20gMTg5"
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7147,
                      "q": "VHJp4buBdSBOZ3V54buFbiBjaMOtbmggdGjhu6ljIHhlbSB2aeG7h2MgZOG7sW5nIGJpYSBjaOG7pyBxdXnhu4FuIGPhu6dhIFZp4buHdCBOYW0gdHLDqm4gdOG7q25nIGjDsm4gxJHhuqNvIGPhu6dhIGhhaSBxdeG6p24gxJHhuqNvIEhvw6BuZyBTYSB2w6AgVHLGsOG7nW5nIFNhIGLhuq90IMSR4bqndSB04burIHRo4budaSBnaWFuIG7DoG8/",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 3,
                      "minuspoint": 0,
                      "idx_true": [
                        2
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "TsSDbSAxODM3"
                        },
                        {
                          "id": 1,
                          "text": "TsSDbSAxODM5"
                        },
                        {
                          "id": 2,
                          "text": "TsSDbSAxODM2"
                        },
                        {
                          "id": 3,
                          "text": "TsSDbSAxODM4"
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7137,
                      "q": "U+G7sSBraeG7h24g4oCcxJHhuqNvIEfhuqFjIE1h4oCdLCBUcnVuZyBRdeG7kWMgZMO5bmcgdsWpIGzhu7FjIMSRw6FuaCBjaGnhur9tIMSR4bqjbyBH4bqhYyBNYSBj4bunYSBWaeG7h3QgTmFtIOG7nyBkaeG7hW4gcmEgdsOgbyBuZ8OgeSBuw6BvPw==",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 4,
                      "minuspoint": 0,
                      "idx_true": [
                        0
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "TmfDoHkgMTQvMy8xOTg4"
                        },
                        {
                          "id": 1,
                          "text": "TmfDoHkgMTMvMy8xOTg4"
                        },
                        {
                          "id": 2,
                          "text": "TmfDoHkgMTIvMy8xOTg4"
                        },
                        {
                          "id": 3,
                          "text": "TmfDoHkgMTUvMy8xOTg4"
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7136,
                      "q": "TsSDbSAxOTU5LCBC4buZIFF14buRYyBwaMOybmcgdGjDoG5oIGzhuq1wIMSRxqFuIHbhu4sgbMOgbSBuaGnhu4dtIHbhu6UgY2hpIHZp4buHbiB2xakga2jDrSBjaG8gY2hp4bq/biB0csaw4budbmcgTWnhu4FuIE5hbSBi4bqxbmcgxJHGsOG7nW5nIGJp4buDbiBjw7MgdMOqbiBn4buNaSBiw60gbeG6rXQgbMOgIGfDrD8=",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 5,
                      "minuspoint": 0,
                      "idx_true": [
                        1
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "xJBvw6BuIDU1OQ=="
                        },
                        {
                          "id": 1,
                          "text": "4oCcVOG6rXAgxJFvw6BuIMSRw6FuaCBjw6EgU8O0bmcgR2lhbmjigJ0u"
                        },
                        {
                          "id": 2,
                          "text": "VOG6rXAgxJFvw6BuIMSRw6FuaCBjw6EgNjAz"
                        },
                        {
                          "id": 3,
                          "text": "xJBvw6BuIHTDoHUga2jDtG5nIHPhu5E="
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7135,
                      "q": "Q2jDumEgTmd1eeG7hW4gbOG6rXAgcmEgdOG7lSBjaOG7qWMgZ8OsIMSR4buDIHF14bqjbiBsw70sIGtoYWkgdGjDoWMgQmnhu4NuIMSQw7RuZz8=",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 6,
                      "minuspoint": 0,
                      "idx_true": [
                        1
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "xJDhu5lpIFRyxrDhu51uZyBTYSB2w6AgxJHhu5lpIELhuq9jIEjhuqNpLg=="
                        },
                        {
                          "id": 1,
                          "text": "xJDhu5lpIEhvw6BuZyBTYSB2w6AgxJHhu5lpIELhuq9jIEjhuqNp"
                        },
                        {
                          "id": 2,
                          "text": "xJDhu5lpIMSQw7RuZyBI4bqjaSB2w6AgxJHhu5lpIE5hbSBI4bqjaS4="
                        },
                        {
                          "id": 3,
                          "text": "xJDhu5lpIE5hbSBI4bqjaQ=="
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7134,
                      "q": "Q8OhYyB0cmnhu4F1IMSR4bqhaSBwaG9uZyBraeG6v24gVmnhu4d0IE5hbSDEkcOjIGNoaeG6v20gaOG7r3UgdsOgIHRo4buxYyB0aGkgY2jhu6cgcXV54buBbiDEkeG7kWkgduG7m2kgcXXhuqduIMSR4bqjbyBIb8OgbmcgU2EgdsOgIHF14bqnbiDEkeG6o28gVHLGsOG7nW5nIFNhIHThu6sgdGjhur8ga+G7tyB0aOG7qSBt4bqleT8=",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 7,
                      "minuspoint": 0,
                      "idx_true": [
                        1
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "VGjhur8ga+G7tyBYVklJSQ=="
                        },
                        {
                          "id": 1,
                          "text": "VGjhur8ga+G7tyBYVklJ"
                        },
                        {
                          "id": 2,
                          "text": "VGjhur8ga+G7tyBYVkk="
                        },
                        {
                          "id": 3,
                          "text": "VGjhur8ga+G7tyBYSVg="
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7133,
                      "q": "QuG6oW4gaMOjeSBjaG8gYmnhur90IHBoYW8gc+G7kSDigJww4oCdIHRyw6puIGJp4buDbiBjw7MgbmdoxKlhIGzDoCBnw6w/",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 8,
                      "minuspoint": 0,
                      "idx_true": [
                        0
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "TMOgIMSRaeG7g20gxJHhuqd1IHRpw6puIGPhu6dhIGjhu4cgdGjhu5FuZyBwaGFvIGx14buTbmcgxJHhu4MgY2hvIMKgdMOgdSDCoHRodXnhu4FuIHbDoG8gwqBj4bqjbmcgxJHGsOG7o2MgwqB0aHXhuq1uIMKgbOG7o2kgdsOgIGFuIHRvw6BuLg=="
                        },
                        {
                          "id": 1,
                          "text": "TMOgIGNo4bunIHF1eeG7gW4gdHLDqm4gYmnhu4Nu"
                        },
                        {
                          "id": 2,
                          "text": "TMOgIGJpw6puIGdp4bubaSBxdeG7kWMgZ2lhIHRyw6puIGJp4buDbg=="
                        },
                        {
                          "id": 3,
                          "text": "TMOgIG5o4bqxbSBi4bqjbyB24buHIGFuIG5pbmgsIGLhuqNvIHbhu4cgY8OhYyBxdXnhu4FuIGzhu6NpIHRyw6puIGJp4buDbi4="
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7132,
                      "q": "THXhuq10IG7DoG8gcXV5IMSR4buLbmggduG7gSDEkcaw4budbmcgY8ahIHPhu58sIG7hu5lpIHRo4buneSwgbMOjbmggaOG6o2ksIHbDuW5nIHRp4bq/cCBnacOhcCBsw6NuaCBo4bqjaSwgdsO5bmcgxJHhurdjIHF1eeG7gW4ga2luaCB04bq/LCB0aOG7gW0gbOG7pWMgxJHhu4thLCBjw6FjIMSR4bqjbywgcXXhuqduIMSR4bqjbyBIb8OgbmcgU2EsIHF14bqnbiDEkeG6o28gVHLGsOG7nW5nIFNhIHbDoCBxdeG6p24gxJHhuqNvIGtow6FjIHRodeG7mWMgY2jhu6cgcXV54buBbiwgcXV54buBbiBjaOG7pyBxdXnhu4FuLCBxdXnhu4FuIHTDoGkgcGjDoW4gcXXhu5FjIGdpYSBj4bunYSBWaeG7h3QgTmFtOyBob+G6oXQgxJHhu5luZyB0cm9uZyB2w7luZyBiaeG7g24gVmnhu4d0IE5hbTsgcGjDoXQgdHJp4buDbiBraW5oIHThur8gYmnhu4NuOyBxdeG6o24gbMO9IHbDoCBi4bqjbyB24buHIGJp4buDbiwgxJHhuqNvLg==",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 9,
                      "minuspoint": 0,
                      "idx_true": [
                        3
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "THXhuq10IGJpw6puIGdp4bubaSBxdeG7kWMgZ2lhIFZp4buHdCBOYW0="
                        },
                        {
                          "id": 1,
                          "text": "Q8O0bmcgxrDhu5tjIExpw6puIEjhu6NwIFF14buRYyB24buBIEx14bqtdCBiaeG7g24gbsSDbSAxOTgy"
                        },
                        {
                          "id": 2,
                          "text": "THXhuq10IEJp4buDbiBxdeG7kWMgdOG6vy4="
                        },
                        {
                          "id": 3,
                          "text": "THXhuq10IEJp4buDbiBWaeG7h3QgTmFt"
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7131,
                      "q": "VsSDbiBi4bqjbiBuw6BvIHNhdSDEkcOieSDEkcaw4bujYyBjb2kgbMOgIGhp4bq/biBwaMOhcCBj4bunYSB0aOG6vyBnaeG7m2kgduG7gSBjw6FjIHbhuqVuIMSR4buBIGJp4buDbiB2w6AgxJHhuqFpIGTGsMahbmc/wqA=",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 10,
                      "minuspoint": 0,
                      "idx_true": [
                        0
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "Q8O0bmcgxrDhu5tjIExpw6puIEjhu6NwIFF14buRYyB24buBIEx14bqtdCBiaeG7g24gbsSDbSAxOTgy"
                        },
                        {
                          "id": 1,
                          "text": "THXhuq10IEJp4buDbiBxdeG7kWMgdOG6vw=="
                        },
                        {
                          "id": 2,
                          "text": "SGnhur9uIENoxrDGoW5nIExpw6puIEjhu6NwIFF14buRYw=="
                        },
                        {
                          "id": 3,
                          "text": "VHV5w6puIGLhu5EgduG7gSDhu6luZyB44butIGPDoWMgYsOqbiDhu58gQmnhu4NuIMSQw7RuZy4="
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7130,
                      "q": "Q2hp4bq/biBsxrDhu6NjIEJp4buDbiBWaeG7h3QgTmFtIMSR4bq/biBuxINtIDIwMjAgxJHDoyDEkcaw4bujYyBCYW4gQ2jhuqVwIGjDoG5oIFRydW5nIMawxqFuZyDEkOG6o25nIEPhu5luZyBz4bqjbiBWaeG7h3QgTmFtIGtow7NhIG3huqV5IHRow7RuZyBxdWE/",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 11,
                      "minuspoint": 0,
                      "idx_true": [
                        0
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "S2jDs2EgWCwgbmhp4buHbSBr4buzIDIwMDUg4oCTIDIwMTA="
                        },
                        {
                          "id": 1,
                          "text": "S2jDs2EgVklJSSwgbmhp4buHbSBr4buzIDE5OTUgLSAyMDAw"
                        },
                        {
                          "id": 2,
                          "text": "S2jDs2EgSVgsIG5oaeG7h20ga+G7syAyMDAwIC0gMjAwNQ=="
                        },
                        {
                          "id": 3,
                          "text": "S2jDs2EgWEksIG5oaeG7h20ga+G7syAyMDEwLTIwMTU="
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7129,
                      "q": "Tmd1ecOqbiBuaMOibiBjaMOtbmggZ8OieSBuw6puIGhp4buHbiB0xrDhu6NuZyBzw7NuZyB0aOG6p24gbMOgIGfDrD8=",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 12,
                      "minuspoint": 0,
                      "idx_true": [
                        3
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "TsO6aSBs4butYSBkxrDhu5tpIMSRw6F5IGJp4buDbg=="
                        },
                        {
                          "id": 1,
                          "text": "U2nDqnUgYsOjbyB0csOqbiBCaeG7g24="
                        },
                        {
                          "id": 2,
                          "text": "VGjhu6d5IHRyaeG7gXUgZMOibmcgY2Fv"
                        },
                        {
                          "id": 3,
                          "text": "xJDhu5luZyDEkeG6pXQgZMaw4bubaSDEkcOheSBiaeG7g24="
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7128,
                      "q": "4oCcVGFtIGdpw6FjIHZ1w7RuZ+KAnSBjw7MgaMOsbmggZMOhbmcgZ2nhu5FuZyB24bubaSDEkeG6o28gbsOgbyB0aHXhu5ljIHF14bqnbiDEkeG6o28gVHLGsOG7nW5nIFNhPw==",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 13,
                      "minuspoint": 0,
                      "idx_true": [
                        3
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "xJDhuqNvIFPGoW4gQ2E="
                        },
                        {
                          "id": 1,
                          "text": "xJDhuqNvIMSQw6EgTGVuIMSQYW8="
                        },
                        {
                          "id": 2,
                          "text": "xJDhuqNvIFNvbmcgVOG7rSBUw6J5"
                        },
                        {
                          "id": 3,
                          "text": "xJDhuqNvIFRyxrDhu51uZyBTYQ=="
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7127,
                      "q": "TG/DoGkgdGjhu7FjIHbhuq10IG7DoG8gc2F1IMSRw6J5IHh14bqldCBoaeG7h24gbmhp4buBdSB0csOqbiBjw6FjIGLDoGkgdGjGoSwgYsOgaSBow6F0IHbhu4EgVHLGsOG7nW5nIFNhOg==",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 14,
                      "minuspoint": 0,
                      "idx_true": [
                        0
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "Q8OieSBiw6BuZyB2dcO0bmc="
                        },
                        {
                          "id": 1,
                          "text": "Q8OieSBsaeG7hXU="
                        },
                        {
                          "id": 2,
                          "text": "Q8OieSBob2EgcGjGsOG7o25n"
                        },
                        {
                          "id": 3,
                          "text": "Q8OieSBwaGkgbGFv"
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7126,
                      "q": "VHJvbmcgNCDEkeG7i2EgcGjGsMahbmcgZMaw4bubaSDEkcOieSwgdGhlbyBi4bqhbiDEkeG7i2EgcGjGsMahbmcgbsOgbyBraMO0bmcgdGnhur9wIGdpw6FwIHbhu5tpIEJp4buDbiDEkMO0bmc/",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 15,
                      "minuspoint": 0,
                      "idx_true": [
                        3
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "TmluaCBUaHXhuq1u"
                        },
                        {
                          "id": 1,
                          "text": "QsOsbmggVGh14bqtbg=="
                        },
                        {
                          "id": 2,
                          "text": "TmluaCBIw7JhLg=="
                        },
                        {
                          "id": 3,
                          "text": "QsOsbmggUGjGsOG7m2M="
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7125,
                      "q": "VGjhu51pIGPDoWMgdnVhIG5ow6AgTmd1eeG7hW4gKMSR4budaSB2dWEgTWluaCBN4bqhbmcpLCBRdeG6p24gxJHhuqNvIFRyxrDhu51uZyBTYSBjw7MgdMOqbiBn4buNaSBsw6AgZ8OsOg==",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 16,
                      "minuspoint": 0,
                      "idx_true": [
                        0
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "VuG6oW4gbMO9IFRyxrDhu51uZyBTYQ=="
                        },
                        {
                          "id": 1,
                          "text": "xJDhuqFpIFRyxrDhu51uZyBTYSDEkeG6o28="
                        },
                        {
                          "id": 2,
                          "text": "VGhpw6puIEzDvSBTYSBIb8Ogbmc="
                        },
                        {
                          "id": 3,
                          "text": "QsOjaSBjw6F0IHbDoG5n"
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7124,
                      "q": "UXXhuqduIMSR4bqjbyBIb8OgbmcgU2EgY8OzIHTDqm4gdGnhur9uZyBBbmggbMOgOg==",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 17,
                      "minuspoint": 0,
                      "idx_true": [
                        2
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "S2VwdWxhdWFuIFNwcmF0bHk="
                        },
                        {
                          "id": 1,
                          "text": "U3ByYXRseSBJc2xhbmRz"
                        },
                        {
                          "id": 2,
                          "text": "UGFyYWNlbCBJc2xhbmRz"
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7123,
                      "q": "xJDhuqNvIG7DoG8gY+G7p2EgVmnhu4d0IE5hbSBjw7MgbeG6rXQgxJHhu5kgZMOibiBz4buRIHRyw6puIMSR4bqjbyDEkcO0bmcgbmjhuqV0IHNvIHbhu5tpIGPDoWMgxJHhuqNvIGtow6FjP8Kg",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 18,
                      "minuspoint": 0,
                      "idx_true": [
                        0
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "TMO9IFPGoW4="
                        },
                        {
                          "id": 1,
                          "text": "VGjhu5UgQ2h1"
                        },
                        {
                          "id": 2,
                          "text": "UGjDuiBRdeG7kWM="
                        },
                        {
                          "id": 3,
                          "text": "Q8OhdCBCw6A="
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7121,
                      "q": "Tsaw4bubYyB0YSBjw7MgYmFvIG5oacOqdSB04buJbmgsIHRow6BuaCBwaOG7kSB0aeG6v3AgZ2nDoXAgduG7m2kgYmnhu4NuPw==",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 19,
                      "minuspoint": 0,
                      "idx_true": [
                        0
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "MjggdOG7iW5oLCB0aMOgbmggcGjhu5E="
                        },
                        {
                          "id": 1,
                          "text": "MjcgdOG7iW5oLCB0aMOgbmggcGjhu5E="
                        },
                        {
                          "id": 2,
                          "text": "MjYgdOG7iW5oLCB0aMOgbmggcGjhu5E="
                        },
                        {
                          "id": 3,
                          "text": "MjkgdOG7iW5oLCB0aMOgbmggcGjhu5E="
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7122,
                      "q": "QuG6oW4gaMOjeSBjaG8gYmnhur90IGRp4buHbiB0w61jaCBCaeG7g24gxJDDtG5nIHLhu5luZyBraG/huqNuZyBiYW8gbmhpw6p1IGttMj8=",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 0,
                      "point": 5,
                      "ordinal": 20,
                      "minuspoint": 0,
                      "idx_true": [
                        0
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "S2hv4bqjbmcgMy40NDcuMDAwIGttMg=="
                        },
                        {
                          "id": 1,
                          "text": "S2hv4bqjbmcgNS40NDcuMDAwIGttMg=="
                        },
                        {
                          "id": 2,
                          "text": "S2hv4bqjbmcgNC40NDcuMDAwIGttMg=="
                        },
                        {
                          "id": 3,
                          "text": "S2hv4bqjbmcgNi40NDcuMDAwIGttMg=="
                        }
                      ],
                      "image": "?v=1537241969"
                    }
                  ]
                },
                {
                  "round_id": 384,
                  "round_name": "Vòng 2",
                  "round_name_2": 2,
                  "number_question": 10,
                  "point": 100,
                  "listQuestRound": [
                    {
                      "id": 7150,
                      "q": "VOG7lW5nIEPDtG5nIHR5IFTDom4gQ+G6o25nIFPDoGkgR8OybiAtIFF1w6JuIGPhuqNuZyBTw6BpIEfDsm4gbMOgIGRvYW5oIG5naGnhu4dwIGjDoG5nIMSR4bqndSBob+G6oXQgxJHhu5luZyB0cm9uZyBsxKluaCB24buxYzogwqA=",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 30000,
                      "point": 10,
                      "ordinal": 21,
                      "minuspoint": 0,
                      "idx_true": [
                        1
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "WMOieSBk4buxbmcgY8OhYyBjw7RuZyB0csOsbmggdHLDqm4gYmnhu4Nu"
                        },
                        {
                          "id": 1,
                          "text": "S2hhaSB0aMOhYyBj4bqjbmc7IGThu4tjaCB24bulIGxvZ2lzdGljczsgduG6rW4gdOG6o2kgdsOgIGThu4tjaCB24bulIGJp4buDbi4="
                        },
                        {
                          "id": 2,
                          "text": "S2hhaSB0aMOhYyBk4bqndSBraMOt"
                        },
                        {
                          "id": 3,
                          "text": "wqBLaGFpIHRow6FjIGPhuqNuZzsgxJHDoW5oIGLhuq90IGjhuqNpIHPhuqNu"
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7146,
                      "q": "VOG7iW5oIOG7p3kgxJDhuq9rIE7DtG5nIHbDoCDEkOG6o25nIOG7p3kgUXXDom4gY2jhu6duZyBI4bqjaSBxdcOibiBrw70ga+G6v3QgQ2jGsMahbmcgdHLDrG5oIHBo4buRaSBo4bujcCB0dXnDqm4gdHJ1eeG7gW4gYmnhu4NuLCDEkeG6o28gbmfDoHkgbsOgbz8=",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 30000,
                      "point": 10,
                      "ordinal": 22,
                      "minuspoint": 0,
                      "idx_true": [
                        1
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "TmfDoHkgMjIvNy8yMDE3"
                        },
                        {
                          "id": 1,
                          "text": "TmfDoHkgMjAvNy8yMDE3"
                        },
                        {
                          "id": 2,
                          "text": "TmfDoHkgMjEvNy8yMDE3"
                        },
                        {
                          "id": 3,
                          "text": "TmfDoHkgMjMvNy8yMDE3"
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7145,
                      "q": "WcOqdSBzw6FjaCBwaGkgbMO9IOKAnMSRxrDhu51uZyBsxrDhu6FpIGLDsuKAnSAoaGF5IOKAnMSRxrDhu51uZyA5IGtow7pjIMSR4bupdCDEkW/huqFu4oCdKSBj4bunYSBUcnVuZyBRdeG7kWMgxJHGsOG7o2MgxJHGsGEgcmEgdOG7qyBraGkgbsOgbz/CoA==",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 30000,
                      "point": 10,
                      "ordinal": 23,
                      "minuspoint": 0,
                      "idx_true": [
                        2
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "VOG7qyBuxINtIDIwMDc="
                        },
                        {
                          "id": 1,
                          "text": "VOG7qyBow6BuZyBuZ8OgbiBuxINtIHRyxrDhu5tj"
                        },
                        {
                          "id": 2,
                          "text": "VOG7qyBuxINtIDE4NDc="
                        },
                        {
                          "id": 3,
                          "text": "VOG7qyBuxINtIDE5NDc="
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7144,
                      "q": "4oCcVGjhur8ga+G7tyBYWEkgxJHGsOG7o2MgdGjhur8gZ2nhu5tpIHhlbSBsw6AgdGjhur8ga+G7tyBj4bunYSDEkeG6oWkgZMawxqFuZ+KAnSwgcXVhbiDEkWnhu4NtIG7DoHkgxJHGsOG7o2MgbmjhuqVuIG3huqFuaCB0cm9uZyB2xINuIGLhuqNuIG7DoG8gc2F1IMSRw6J5Pw==",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 30000,
                      "point": 10,
                      "ordinal": 24,
                      "minuspoint": 0,
                      "idx_true": [
                        3
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "THXhuq10IEJp4buDbiBWaeG7h3QgTmFtIChuxINtIDIwMTIpLg=="
                        },
                        {
                          "id": 1,
                          "text": "Tmdo4buLIHF1eeG6v3Qgc+G7kSAwMy1OUS9UVywgbmfDoHkgNi81LzE5OTMgY+G7p2EgQuG7mSBDaMOtbmggdHLhu4sgKGtow7NhIFZJKSB24buBIG3hu5l0IHPhu5Egbmhp4buHbSB24bulIHBow6F0IHRyaeG7g24ga2luaCB04bq/IGJp4buDbiB0cm9uZyBuaOG7r25nIG7Eg20gdHLGsOG7m2MgbeG6r3Q="
                        },
                        {
                          "id": 2,
                          "text": "Q2jhu4kgdGjhu4sgc+G7kSAyMC1DVC9UVywgbmfDoHkgMjIvOS8xOTk3IGPhu6dhIELhu5kgQ2jDrW5oIHRy4buLIChraMOzYSBWSUlJKSB24buBIMSR4bqpeSBt4bqhbmggcGjDoXQgdHJp4buDbiBraW5oIHThur8gYmnhu4NuIHRoZW8gaMaw4bubbmcgY8O0bmcgbmdoaeG7h3AgaMOzYSwgaGnhu4duIMSR4bqhaSBow7Nh"
                        },
                        {
                          "id": 3,
                          "text": "Tmdo4buLIHF1eeG6v3Qgc+G7kSAwOS1OUS9UVywgbmfDoHkgMDkvMDIvMjAwNyBj4bunYSBCYW4gQ2jhuqVwIGjDoG5oIFRydW5nIMawxqFuZyDEkOG6o25nIChraMOzYSBYKSB24buBIENoaeG6v24gbMaw4bujYyBiaeG7g24gVmnhu4d0IE5hbSDEkeG6v24gbsSDbSAyMDIw"
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7143,
                      "q": "UXVhbiDEkWnhu4NtIGPhu6dhIMSQ4bqjbmcsIE5ow6Agbsaw4bubYyB0YSB0cm9uZyB2aeG7h2MgYuG6o28gduG7hyBjaOG7pyBxdXnhu4FuIGJp4buDbiwgxJHhuqNvOyBnaeG6o2kgcXV54bq/dCBuaOG7r25nIHRyYW5oIGNo4bqlcCBsw6NuaCB0aOG7lSB2w6AgcXV54buBbiB0w6BpIHBow6FuIHRyw6puIGJp4buDbiDEkMO0bmc6",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 30000,
                      "point": 10,
                      "ordinal": 25,
                      "minuspoint": 0,
                      "idx_true": [
                        3
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "R2nhuqNpIHF1eeG6v3QgbcOidSB0aHXhuqtuIHRow7RuZyBxdWEgTHXhuq10IHBow6FwIFF14buRYyB04bq/"
                        },
                        {
                          "id": 1,
                          "text": "R2nhuqNpIHF1eeG6v3QgbcOidSB0aHXhuqtuIHRow7RuZyBxdWEgdGjGsMahbmcgbMaw4bujbmc7IG7hur91IGPhuqduIHRow6wgc+G7rSBk4bulbmcgaG/hurdjIMSRZSBk4buNYSBz4butIGThu6VuZyB2xakgbOG7sWM7"
                        },
                        {
                          "id": 2,
                          "text": "R2nhuqNpIHF1eeG6v3QgbcOidSB0aHXhuqtuIHRow7RuZyBxdWEgdGjGsMahbmcgbMaw4bujbmcu"
                        },
                        {
                          "id": 3,
                          "text": "S2jDtG5nIHPhu60gZOG7pW5nIGhv4bq3YyDEkWUgZOG7jWEgc+G7rSBk4bulbmcgdsWpIGzhu7FjOyBHaeG6o2kgcXV54bq/dCBtw6J1IHRodeG6q24gdGjDtG5nIHF1YSB0aMawxqFuZyBsxrDhu6NuZyBob8OgIGLDrG5oIHRyw6puIGPGoSBz4bufIHTDtG4gdHLhu41uZyDEkeG7mWMgbOG6rXAsIGNo4bunIHF1eeG7gW4sIHRvw6BuIHbhurluIGzDo25oIHRo4buVLCBwaMO5IGjhu6NwIHbhu5tpIGPDoWMgbmd1ecOqbiB04bqvYyBwaOG7lSBj4bqtcCBj4bunYSBsdeG6rXQgcGjDoXAgcXXhu5FjIHThur8u"
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7142,
                      "q": "xJDhu4Egw6FuIHR1ecOqbiB0cnV54buBbiBi4bqjbyB24buHIGNo4bunIHF1eeG7gW4gdsOgIHBow6F0IHRyaeG7g24gYuG7gW4gduG7r25nIGJp4buDbiwgxJHhuqNvIFZp4buHdCBOYW0gZ2lhaSDEkW/huqFuIDIwMTgg4oCTIDIwMjAsIMSR4buBIHJhIG3hu6VjIHRpw6p1IGJhbyBuaGnDqnUgJSBo4buNYyBzaW5oLCBzaW5oIHZpw6puIHRyb25nIGPDoWMgdHLGsOG7nW5nIMSR4bqhaSBo4buNYywgY2FvIMSR4bqzbmcsIHRydW5nIGPhuqVwLCBUSFBULCBUSENTIMSRxrDhu6NjIGN1bmcgY+G6pXAgdGjDtG5nIHRpbiwga2nhur9uIHRo4bupYyB24buBIGNo4bunIHF1eeG7gW4gYmnhu4NuLCDEkeG6o28gVmnhu4d0IE5hbT8u",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 30000,
                      "point": 10,
                      "ordinal": 26,
                      "minuspoint": 0,
                      "idx_true": [
                        3
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "OTAl"
                        },
                        {
                          "id": 1,
                          "text": "NTAl"
                        },
                        {
                          "id": 2,
                          "text": "OTkl"
                        },
                        {
                          "id": 3,
                          "text": "MTAwJQ=="
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7141,
                      "q": "4bqkbiBwaOG6qW0gKHTDoGkgbGnhu4d1KSBuw6BvIOG7nyB0aOG7nWkgQ2jDumEgVHLhu4tuaCAoMTY4MCAtIDE3MDUpIMSRxrDhu6NjIGNvaSBsw6AgdsSDbiBraeG7h24gY+G7p2EgTmjDoCBuxrDhu5tjLCB0w6BpIGxp4buHdSBjaMOtbmggdGjhu6ljIGPhu6dhIFF14buRYyBnaWEgdsOgIGzDoCBt4buZdCB0cm9uZyBuaOG7r25nIFTDoWMgcGjhuqltIMSR4bqndSB0acOqbiDEkeG7gSBj4bqtcCDEkeG6v24gY2jhu6cgcXV54buBbiBj4bunYSBWaeG7h3QgTmFtIOG7nyBIb8OgbmcgU2EgdsOgIFRyxrDhu51uZyBTYT8=",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 30000,
                      "point": 10,
                      "ordinal": 27,
                      "minuspoint": 0,
                      "idx_true": [
                        0
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "VGhpw6puIE5hbSB04bupIGNow60gbOG7mSDEkeG7kyB0aMaw"
                        },
                        {
                          "id": 1,
                          "text": "UGjhu6cgYmnDqm4gdOG6oXAgbOG7pWM="
                        },
                        {
                          "id": 2,
                          "text": "xJDhuqFpIE5hbSB0aOG7kW5nIG5o4bqldCB0b8OgbiDEkeG7k8Kg"
                        },
                        {
                          "id": 3,
                          "text": "xJDhuqFpIE5hbSB0aOG7sWMgbOG7pWM="
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7140,
                      "q": "TMOgIFbhu4tuaCBu4buVaSB0aeG6v25nIGPhu6dhIFZp4buHdCBOYW0uIE7hurFtIGPDoWNoIHRow6BuaCBwaOG7kSBOaGEgVHJhbmcgODBrbSB24buBIHBow61hIGLhuq9jLiBW4buLbmggY8OzIMSR4buLYSBow6xuaCBy4bqldCBwaG9uZyBwaMO6LCDEkeG6t2MgYmnhu4d0IGzDoCBo4buHIHRo4buRbmcgxJHhuqNvLCBiw6FuIMSR4bqjbywgduG7i25oIHPDonUga8OtbiBnacOzLCBi4budIHbDoCBiw6NpIGJp4buDbiwgY+G7k24gY8OhdCBo4bqlcCBk4bqrbiB2w6AgbMOgIGtodSB24buxYyBjw7MgaOG7hyBzaW5oIHRow6FpIMSRYSBk4bqhbmcgbmjGsCBy4burbmcgbmhp4buHdCDEkeG7m2ksIHLhu6tuZyBuZ+G6rXAgbeG6t24sIMSR4buZbmcgdGjhu7FjIHbhuq10IHZlbiBiaeG7g27igKYgQuG6oW4gaMOjeSBjaG8gYmnhur90IMSRw7MgbMOgIHbhu4tuaCBuw6BvPw==",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 30000,
                      "point": 10,
                      "ordinal": 28,
                      "minuspoint": 0,
                      "idx_true": [
                        3
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "VuG7i25oIEjhuqEgTG9uZw=="
                        },
                        {
                          "id": 1,
                          "text": "VuG7i25oIENhbSBSYW5o"
                        },
                        {
                          "id": 2,
                          "text": "VuG7i25oIE5pbmggVsOibg=="
                        },
                        {
                          "id": 3,
                          "text": "VuG7i25oIFbDom4gUGhvbmc="
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7139,
                      "q": "UXXhuqduIMSR4bqjbyBIb8OgbmcgU2EgdHLhu7FjIHRodeG7mWMgaHV54buHbiDEkeG6o28gSG/DoG5nIFNhLCB0aMOgbmggcGjhu5EgxJDDoCBO4bq1bmcgY8OzIGtob+G6o25nIGJhbyBuaGnDqnUgxJHhuqNvLCDEkcOhLCBj4buTbiBzYW4gaMO0LCBiw6NpIGPhuqFuPw==",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 30000,
                      "point": 10,
                      "ordinal": 29,
                      "minuspoint": 0,
                      "idx_true": [
                        2
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "VHLDqm4gNDAgxJHhuqNvLCDEkcOhLCBj4buTbiwgYsOjaSBj4bqhbg=="
                        },
                        {
                          "id": 1,
                          "text": "VHLDqm4gMzUgxJHhuqNvLCDEkcOhLCBj4buTbiwgYsOjaSBj4bqhbg=="
                        },
                        {
                          "id": 2,
                          "text": "VHLDqm4gMzAgxJHhuqNvLCDEkcOhLCBj4buTbiwgYsOjaSBj4bqhbg=="
                        },
                        {
                          "id": 3,
                          "text": "VHLDqm4gMjUgxJHhuqNvLCDEkcOhLCBj4buTbiwgYsOjaSBj4bqhbg=="
                        }
                      ],
                      "image": "?v=1537241969"
                    },
                    {
                      "id": 7138,
                      "q": "SOG6o2kgcXXDom4gVmnhu4d0IE5hbSBy4bqldCB2aW5oIGThu7EgdsOgIHThu7EgaMOgbyDEkcaw4bujYyDEkcOzbiBCw6FjIEjhu5MgduG7gSB0aMSDbSAzIGzhuqduLCBM4bqnbiBjdeG7kWkgY3Xhu5FpIGPDuW5nIELDoWMgduG7gSB0aMSDbSBs4bqhaSBI4bqjaSBxdcOibiBWaeG7h3QgTmFtIGzDoCBuZ8OgeSBuw6BvPw==",
                      "dis": 1,
                      "play_type": 4,
                      "play_name": "Trắc nghiệm thường",
                      "type": 1,
                      "content": null,
                      "audio": "",
                      "video": "",
                      "time": 30000,
                      "point": 10,
                      "ordinal": 30,
                      "minuspoint": 0,
                      "idx_true": [
                        1
                      ],
                      "ans": [
                        {
                          "id": 0,
                          "text": "MTMvOC8xOTYy"
                        },
                        {
                          "id": 1,
                          "text": "MTMvMTEvMTk2Mg=="
                        },
                        {
                          "id": 2,
                          "text": "MTMvMTAvMTk2Mg=="
                        },
                        {
                          "id": 3,
                          "text": "MTMvOS8xOTYy"
                        }
                      ],
                      "image": "?v=1537241969"
                    }
                  ]
                }
              ]
            }';
    }

    public function getUserInfo(Request $request){
        if(!empty($request->user_id)){
            $info = UserContestInfo::where('user_id','=',$request->user_id)->first();
            if(empty($info)){
                $info = new UserContestInfo();
                $info->user_id = $request->user_id;
                $info->is_lock = false;
                $current_exam = [
                    'round' => 0,
                    'topic' => 0,
                    'times' => 0,
                    'status' => 0
                ];
                $info->current_exam = $current_exam;
                $exam_result = [];
                $round_list = ContestRound::where(['round_type' => 'real', 'status' => '1'])->get();
                if(!empty($round_list)){
                    foreach ($round_list as $key => $item) {
                        $exam_result[$item->round_id] = [];
                        $topic_list = ContestTopic::where(['round_id' => $item->round_id, 'status' => '1'])->get();
                        if(!empty($topic_list)){
                            foreach ($topic_list as $key1 => $item1) {
                                $exam_result[$item->round_id][$item1->topic_id] = [];
                                if($item1->exam_repeat_time >0){
                                    for($i = 0;$i <= $item1->exam_repeat_time;$i++){
                                        $exam_result[$item->round_id][$item1->topic_id][] = [
                                            'times' => $i+1,
                                            'time_start' => 0,
                                            'time' => -1,
                                            'point' => -1,
                                            'status' => 0
                                        ];
                                    }
                                }
                                else{
                                    $exam_result[$item->round_id][$item1->topic_id][] = [
                                        'times' => 1,
                                        'time_start' => 0,
                                        'time' => -1,
                                        'point' => -1,
                                        'status' => 0
                                    ];
                                }
                            }
                        }
                    }
                }
                $info->exam_result = $exam_result;
                $info->save();
                return response()->json($info);
            }
            else{
                if(!empty($request->round_id)){
                    if(!empty($request->topic_id)){

                    }
                    else{

                    }
                }
                else{
                   $current_exam = $info->current_exam;
                   return response()->json($current_exam);
                }
            }
        }
        else{

        }
    }

    public function updateUserInfo(Request $request){

    }
}