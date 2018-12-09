<?php defined('SC_PANEL') or die; ?>
<!-- Start Status area -->
<div class="notika-status-area">
    <div class="container">
        <div class="row">
            <?php if (!empty($commonStats)) : ?>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                    <div class="website-traffic-ctn">
                        <h2><span class="counter"><?php echo $commonStats['totalTasks']; ?></span></h2>
                        <p>Задач в очереди</p>
                    </div>
                    <!--div class="sparkline-bar-stats1">9,4,8,6,5,6,4,8,3,5,9,5</div-->
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30">
                    <div class="website-traffic-ctn">
                        <h2><span class="counter"><?php echo $commonStats['waitingTasks']; ?></span></h2>
                        <p>Задач в ожидании</p>
                    </div>
                    <!--div class="sparkline-bar-stats2">1,4,8,3,5,6,4,8,3,3,9,5</div-->
                </div>
            </div>
            <?php endif; ?>

            <?php if (empty($filter['userId'])) : ?>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30 dk-res-mg-t-30">
                    <div class="website-traffic-ctn">
                        <h2><span class="counter"><?php echo $currentUserStats['totalTasks']; ?></span></h2>
                        <p>Ваших задач</p>
                    </div>
                    <!--div class="sparkline-bar-stats3">4,2,8,2,5,6,3,8,3,5,9,5</div-->
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="wb-traffic-inner notika-shadow sm-res-mg-t-30 tb-res-mg-t-30 dk-res-mg-t-30">
                    <div class="website-traffic-ctn">
                        <h2><span class="counter"><?php echo $currentUserStats['waitingTasks']; ?></span></h2>
                        <p>Ваших задач в ожидании</p>
                    </div>
                    <!--div class="sparkline-bar-stats4">2,4,8,4,5,7,4,7,3,5,7,5</div-->
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="data-table-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="data-table-list">
                    <div class="basic-tb-hd">
                        <h2><?php echo $page['heading']; ?></h2>
                        <p>Здесь вы можете увидеть информацию о текущем состоянии очереди задач.</p>
                    </div>

                    <div class="text-left">
                        <a href="<?php echo innoUrl(['queue', 'add']); ?>" class="btn btn-success"><i class="fa fa-plus-circle"></i> Добавить новую задачу</a>
                    </div>

                    <p></p>

                    <div class="table-responsive">
                        <table id="queue-table" class="table table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Название</th>
                                <th>Автор</th>
                                <th>Статус</th>
                                <th>Началась</th>
                                <th>Завершится</th>
                                <th>Осталось</th>
                                <th>Ресурсы</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($queue as $task) : ?>
                            <tr class="<?php echo ($task['status'] != 'RUNNING') ? 'warning' : 'success'; ?>">
                                <td><?php echo $task['id']; ?></td>
                                <td><?php echo $task['name']; ?></td>
                                <td><a href="<?php echo innoUrl($currentRouteSection, [  'user' => $task['user_id'] ]); ?>"><?php echo $task['user_name']; ?> (<?php echo $task['user_id']; ?>)</a></td>
                                <td><?php echo ($task['status'] == 'RUNNING') ? 'Выполняется' : 'Ожидает'; ?></td>
                                <td><?php echo ($task['status'] == 'RUNNING') ? $task['start_time']->format('d.m.Y H:i:s') : 'В ожидании до<br>'.$task['start_time']->format('d.m.Y H:i:s'); ?></td>
                                <td><?php echo $task['end_time']->format('d.m.Y H:i:s'); ?></td>
                                <td>
                                    <?php echo $task['time_left']->format('%dд. %H:%I:%S'); ?>
                                    <?php if ($task['accessManage']) : ?>
                                        <br><a class="btn btn-sm btn-warning" href="<?php echo innoUrl([ 'queue', 'cancel' ], [ 'task' => $task['id'] ]); ?>">Отменить</a>
                                    <?php endif; ?>
                                </td>
                                <td><span><strong>Узлы:</strong><span>&nbsp;<?php echo $task['nodes_count']; ?></span></span><br>
                                    <span><strong>CPUs:</strong><span>&nbsp;<?php echo $task['min_cpus_count']; ?></span></span><br>
                                    <span><strong>ОЗУ:</strong><span>&nbsp;<?php echo $task['min_memory']; ?></span></span></td>
                            </tr>
                            <?php endforeach; ?>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Название</th>
                                <th>Автор</th>
                                <th>Статус</th>
                                <th>Началась</th>
                                <th>Завершится</th>
                                <th>Осталось</th>
                                <th>Ресурсы</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Data Table area End-->