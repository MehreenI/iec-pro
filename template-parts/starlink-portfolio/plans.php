<?php

$service_plans = $args['service_plans'] ?? []; 
$tag_line = isset($service_plans['tag_line']) ? $service_plans['tag_line'] : '';

$local_heading = isset($service_plans['heading']) ? $service_plans['heading'] : 'LOCAL PRIORITY';
$local_description = isset($service_plans['description']) ? $service_plans['description'] : '';
$local_details = $service_plans['detail'] ?? array();

$global_heading = isset($service_plans['global_heading']) ? $service_plans['global_heading'] : 'GLOBAL PRIORITY';
$global_description = isset($service_plans['global_description']) ? $service_plans['global_description'] : '';
$global_details = $service_plans['global_detail'] ?? array();
?>
<section class="iec_defualt_position iec_starlink_portfolio_service_plan">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3><?= $service_plans['main_heading']; ?></h3>
                <div class="iec_starlink_portfolio_service_boxes">
                    <div class="iec_starlink_portfolio_service_box_warpper">
                        <div class="iec_starlink_portfolio_service_box">
                            <h5><?= $local_heading; ?></h5>
                            <?= $local_description; ?>
                            <ul class="iec_starlink_portfolio_service_box_list">
                                <?php foreach($local_details as $item): ?>
                                    <li>
                                        <span><?= $item['title']; ?></span>
                                        <strong><?= $item['limit']; ?></strong>
                                    </li>
                                <?php endforeach; ?>

                            </ul>
                        </div>
                    </div>
                    <div class="iec_starlink_portfolio_service_box_warpper">
                        <div class="iec_starlink_portfolio_service_box">
                            <h5><?= $global_heading; ?></h5>
                            <?= $global_description; ?>
                            <ul class="iec_starlink_portfolio_service_box_list">
                                <?php foreach($global_details as $item): ?>
                                    <li>
                                        <span><?= $item['title']; ?></span>
                                        <strong><?= $item['limit']; ?></strong>
                                    </li>
                                <?php endforeach; ?>

                            </ul>
                        </div>
                    </div>
                </div>
                <p><?= $tag_line; ?></p>
            </div>
        </div>
    </div>
</section>
