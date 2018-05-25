<?php
use yii\widgets\LinkPager;
use app\logic\PcViewLogic;
?>
<div class="ac_banner" style="background-image: url('<?php echo Yii::$app->params['pcImageUrl']; ?>/20180410_3_02.jpg');"></div>

<div class="news_contall">
    <div class="cbody">
        <div class="jy-nav">
            <ul>
                <?php
                if(!empty($cate_list)) {
                    foreach ($cate_list as $v) {
                 ?>
                        <li <?php if($get_data['cate_id'] == $v['id'] ) { ?>class="cur"<?php } ?>><a href="<?php echo pcViewLogic::createPageUrl('news','index',array('cate_id'=>$v['id'] )); ?>"><?php echo $v['title']; ?></a></li>
                <?php
                    }
                }
                ?>
            </ul>
        </div>
        <div class="jy-nav-tab">
            <div class="tab-item cur">
                <!-- 公司新闻内容 -->
                <div class="news_contA">
                    <ul class="news_contAul">

                        <?php
                        if(!empty($data['list'])){
                            foreach($data['list'] as $v){
                        ?>
                        <li class="clearfix">
                            <div class="li-time fl">
                                <?php if($v['publish_time']!=0) { ?>
                                <span><?php echo date('Y年', $v['publish_time']); ?></span>
                                <label><?php echo date('m月d日', $v['publish_time']); ?></label>
                                <?php } else { ?>
                                    <span>暂无</span>
                                    <label></label>
                                <?php } ?>

                            </div>
                            <div class="li-cont clearfix fr">
                                <div class="li-img fl">
                                    <img width="220" height="279" src="<?php echo Yii::$app->params['imageUrl'].'/'.$v['image']; ?>" alt="">
                                </div>
                                <div class="li-text fr">
                                    <h4><a href="<?php echo pcViewLogic::createPageUrl('news','details',array('id'=>$v['id'] )); ?>"><?php echo $v['title']; ?></a></h4>
                                    <p><?php echo $v['excerpt']; ?></p>
                                    <a class="xq" href="<?php echo pcViewLogic::createPageUrl('news','details',array('id'=>$v['id'] )); ?>">详细>></a>
                                </div>
                            </div>
                        </li>
                        <?php
                            }
                        }
                        ?>

                    </ul>
                    <nav aria-label="Page navigation" class="navigation">
                        <?php echo LinkPager::widget(['pagination'=>$pages,'nextPageLabel'=>'下一页','prevPageLabel'=>'上一页','maxButtonCount'=>5]); ?>
                    </nav>

                </div>

            </div>


            <!-- 养老政策内容 -->
            <!--<div class="tab-item">

                <div class="news_contA">
                    <ul class="news_contAul">
                        <li class="clearfix">
                            <div class="li-time fl">
                                <span>2018</span>
                                <label>03-09</label>
                            </div>
                            <div class="li-cont clearfix fr">
                                <div class="li-img fl">
                                    <img width="220" height="279" src="<?php /*echo Yii::$app->params['pcImageUrl']; */?>/20180410_3_05.jpg" alt="">
                                </div>
                                <div class="li-text fr">
                                    <h4><a href="">荔湾区区长毕锐明一行莅临医药港施工现场进行调研222</a></h4>
                                    <p>调研中，听取了医药港陈凯旋董事长和卢汉坤总经理对医药港建设项目的详细介绍，对工程项目建设总体有序推进表示肯定，同时就工程建设中遇到的问题与现场人员进行交流探讨，现场办公，解决问题。对下一阶段工作建设进度，让企业早竣工、早投产、早日发挥效益。</p>
                                    <a class="xq" href="">详细>></a>
                                </div>
                            </div>

                        </li>
                        <li class="clearfix">
                            <div class="li-time fl">
                                <span>2018</span>
                                <label>03-07</label>
                            </div>
                            <div class="li-cont clearfix fr">
                                <div class="li-img fl">
                                    <img width="220" height="279" src="<?php /*echo Yii::$app->params['pcImageUrl']; */?>/20180410_3_05.jpg" alt="">
                                </div>
                                <div class="li-text fr">
                                    <h4><a href="">荔湾区区长毕锐明一行莅临医药港施工现场进行调研</a></h4>
                                    <p>调研中，听取了医药港陈凯旋董事长和卢汉坤总经理对医药港建设项目的详细介绍，对工程项目建设总体有序推进表示肯定，同时就工程建设中遇到的问题与现场人员进行交流探讨，现场办公，解决问题。对下一阶段工作建设进度，让企业早竣工、早投产、早日发挥效益。</p>
                                    <a class="xq" href="">详细>></a>
                                </div>
                            </div>

                        </li>
                        <li class="clearfix">
                            <div class="li-time fl">
                                <span>2018</span>
                                <label>03-07</label>
                            </div>
                            <div class="li-cont clearfix fr">
                                <div class="li-img fl">
                                    <img width="220" height="279" src="<?php /*echo Yii::$app->params['pcImageUrl']; */?>/20180410_3_05.jpg" alt="">
                                </div>
                                <div class="li-text fr">
                                    <h4><a href="">荔湾区区长毕锐明一行莅临医药港施工现场进行调研</a></h4>
                                    <p>调研中，听取了医药港陈凯旋董事长和卢汉坤总经理对医药港建设项目的详细介绍，对工程项目建设总体有序推进表示肯定，同时就工程建设中遇到的问题与现场人员进行交流探讨，现场办公，解决问题。对下一阶段工作建设进度，让企业早竣工、早投产、早日发挥效益。</p>
                                    <a class="xq" href="">详细>></a>
                                </div>
                            </div>

                        </li>
                        <li class="clearfix">
                            <div class="li-time fl">
                                <span>2018</span>
                                <label>03-07</label>
                            </div>
                            <div class="li-cont clearfix fr">
                                <div class="li-img fl">
                                    <img width="220" height="279" src="<?php /*echo Yii::$app->params['pcImageUrl']; */?>/20180410_3_05.jpg" alt="">
                                </div>
                                <div class="li-text fr">
                                    <h4><a href="">荔湾区区长毕锐明一行莅临医药港施工现场进行调研</a></h4>
                                    <p>调研中，听取了医药港陈凯旋董事长和卢汉坤总经理对医药港建设项目的详细介绍，对工程项目建设总体有序推进表示肯定，同时就工程建设中遇到的问题与现场人员进行交流探讨，现场办公，解决问题。对下一阶段工作建设进度，让企业早竣工、早投产、早日发挥效益。</p>
                                    <a class="xq" href="">详细>></a>
                                </div>
                            </div>

                        </li>
                    </ul>
                </div>
            </div>-->
        
		
		</div>
    </div>
</div>