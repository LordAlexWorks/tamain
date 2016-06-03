<?php $this->start('pluginCss'); ?>
<?= $this->Html->css(['plugins/footable/footable.core']) ?>
<?php $this->end(); ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?= __("Dashboard") ?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Url->build('/admin'); ?>"><?= __("Home") ?></a>
            </li>
            <li class="active">
                <strong><?= __("Dashboard") ?></strong>
            </li>
        </ol>
    </div>
</div>
<?php echo $this->Flash->render(); ?>
<?php echo $this->Flash->render('auth'); ?>
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">Total</span>
                    <h5>Registered members</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">350</h1>
                    <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                    <small>Members registered</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right">Annual</span>
                    <h5>Re-registration rate</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 class="no-margins">60%</h1>
                        </div>
                        <div class="col-md-6">
                            <div class="stat-percent font-bold text-info">2% <i class="fa fa-level-up"></i> <small> last month</small></div>
                            <div class="font-bold text-navy">44% <i class="fa fa-level-up"></i> <small> last year</small></div>
                        </div>
                    </div>
                    <small>renew their membership</small>
                </div>


            </div>
        </div>
        <div class="col-lg-4">
            <div class="ibox-content ">
                <h5 class="m-b-md">Most common job title</h5>
                <h1 class="no-margins">Co-Fondatrice</h1>
                <small>14% (20 members)</small>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="ibox-content ">
                <h5 class="m-b-md">Average age</h5>
                <h1 class="no-margins">35</h1>
                <small>years-old</small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content text-center">
                    <br><br><br><br><br>
                    PICTURE HERE
                    <br><br><br><br><br>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">             
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>New members in June 2016</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-4">
                            <h1 class="no-margins">7</h1>
                            <small>members</small>
                        </div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="stat-percent font-bold text-navy">2% <i class="fa fa-level-up"></i> <small> last month</small></div>
                            </div>
                            <div class="row">
                                <div class="stat-percent font-bold text-info">44% <i class="fa fa-level-up"></i> <small> last year</small></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <button class="btn btn-primary btn-block m-t"><i class="fa fa-file-excel-o"></i> Export</button>
                    <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Job</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><small>Developer</small></td>
                                <td><i class="fa fa-clock-o"></i> 11:20pm</td>
                                <td>Developer</td>
                                <td class="text-navy"> <i class="fa fa-level-up"></i> 24% </td>
                            </tr>
                            <tr>
                                <td><small>Designer </small></td>
                                <td><i class="fa fa-clock-o"></i> 10:40am</td>
                                <td>Monica</td>
                                <td class="text-navy"> <i class="fa fa-level-up"></i> 66% </td>
                            </tr>
                            <tr>
                                <td><small>Product manager</small> </td>
                                <td><i class="fa fa-clock-o"></i> 01:30pm</td>
                                <td>John</td>
                                <td class="text-navy"> <i class="fa fa-level-up"></i> 54% </td>
                            </tr>
                            <tr>
                                <td><small>Project manager</small> </td>
                                <td><i class="fa fa-clock-o"></i> 02:20pm</td>
                                <td>Agnes</td>
                                <td class="text-navy"> <i class="fa fa-level-up"></i> 12% </td>
                            </tr>
                            <tr>
                                <td><small>CTO</small> </td>
                                <td><i class="fa fa-clock-o"></i> 09:40pm</td>
                                <td>Janet</td>
                                <td class="text-navy"> <i class="fa fa-level-up"></i> 22% </td>
                            </tr>
                            <tr>
                                <td><small>CEO</small> </td>
                                <td><i class="fa fa-clock-o"></i> 04:10am</td>
                                <td>Amelia</td>
                                <td class="text-navy"> <i class="fa fa-level-up"></i> 66% </td>
                            </tr>
                            <tr>
                                <td><small>CFO</small> </td>
                                <td><i class="fa fa-clock-o"></i> 12:08am</td>
                                <td>Damian</td>
                                <td class="text-navy"> <i class="fa fa-level-up"></i> 23% </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">             
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Soon to be expired members</h5>
                    <div class="ibox-tools">
                        <a class="text-navy"><i class="fa fa-file-excel-o text-navy"></i><span class="sr-only">Export</span></a>
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-6 col-md-4">
                            <h1 class="no-margins">15</h1>
                            <small>members</small>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <small><strong>8</strong> in 1st call</small><br>
                            <small><strong>2</strong> in 2nd call</small><br>
                            <small><strong>5</strong> in 3rd call</small>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="row">
                                <div class="stat-percent font-bold text-navy">2% <i class="fa fa-level-up"></i> <small> last month</small></div>
                            </div>
                            <div class="row">
                                <div class="stat-percent font-bold text-info">4% <i class="fa fa-level-up"></i> <small> last year</small></div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <button class="btn btn-primary btn-block m-t"><i class="fa fa-file-excel-o"></i> Export</button>

                    <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th>Exp. date</th>
                                <th>Name</th>
                                <th>Joined in</th>
                                <th>Call</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><small>Pending...</small></td>
                                <td><i class="fa fa-calendar"></i>   05/03/2016</td>
                                <td>Samantha</td>
                                <td class="text-navy"> #1</td>
                            </tr>
                            <tr>
                                <td><span class="label label-warning">Canceled</span> </td>
                                <td><i class="fa fa-calendar"></i>   05/03/2016</td>
                                <td>Monica</td>
                                <td class="text-navy"> #1</td>
                            </tr>
                            <tr>
                                <td><small>Pending...</small> </td>
                                <td><i class="fa fa-calendar"></i>   25/02/2016</td>
                                <td>John</td>
                                <td class="text-info"> #2 </td>
                            </tr>
                            <tr>
                                <td><small>Pending...</small> </td>
                                <td><i class="fa fa-calendar"></i>   12/02/2016</td>
                                <td>Agnes</td>
                                <td class="text-info"> #2 </td>
                            </tr>
                            <tr>
                                <td><small>Pending...</small> </td>
                                <td><i class="fa fa-calendar"></i>   09/01/2016</td>
                                <td>Janet</td>
                                <td class="text-info"> #2 </td>
                            </tr>
                            <tr>
                                <td><span class="label label-primary">Completed</span> </td>
                                <td><i class="fa fa-calendar"></i>   03/01/2016</td>
                                <td>Amelia</td>
                                <td class="text-danger"> #3 </td>
                            </tr>
                            <tr>
                                <td><small>Pending...</small> </td>
                                <td><i class="fa fa-calendar"></i>   03/01/2016</td>
                                <td>Damian</td>
                                <td class="text-danger"> #3 </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Recently expired</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-4">
                            <h1 class="no-margins">7</h1>
                            <small>members</small>
                        </div>
                        <div class="col-sm-8">

                            <div class="row">
                                <div class="stat-percent font-bold text-navy">2% <i class="fa fa-level-up"></i> <small> last month</small></div>
                            </div>
                            <div class="row">
                                <div class="stat-percent font-bold text-info">44% <i class="fa fa-level-up"></i> <small> last year</small></div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <button class="btn btn-primary btn-block m-t"><i class="fa fa-file-excel-o"></i> Export</button>

                    <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th>Exp. date</th>
                                <th>Name</th>

                                <th>Joined in</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><small>Pending...</small></td>
                                <td><i class="fa fa-clock-o"></i> 11:20pm</td>
                                <td>Samantha</td>
                                <td class="text-navy"> <i class="fa fa-level-up"></i> 24% </td>
                            </tr>
                            <tr>
                                <td><span class="label label-warning">Canceled</span> </td>
                                <td><i class="fa fa-clock-o"></i> 10:40am</td>
                                <td>Monica</td>
                                <td class="text-navy"> <i class="fa fa-level-up"></i> 66% </td>
                            </tr>
                            <tr>
                                <td><small>Pending...</small> </td>
                                <td><i class="fa fa-clock-o"></i> 01:30pm</td>
                                <td>John</td>
                                <td class="text-navy"> <i class="fa fa-level-up"></i> 54% </td>
                            </tr>
                            <tr>
                                <td><small>Pending...</small> </td>
                                <td><i class="fa fa-clock-o"></i> 02:20pm</td>
                                <td>Agnes</td>
                                <td class="text-navy"> <i class="fa fa-level-up"></i> 12% </td>
                            </tr>
                            <tr>
                                <td><small>Pending...</small> </td>
                                <td><i class="fa fa-clock-o"></i> 09:40pm</td>
                                <td>Janet</td>
                                <td class="text-navy"> <i class="fa fa-level-up"></i> 22% </td>
                            </tr>
                            <tr>
                                <td><span class="label label-primary">Completed</span> </td>
                                <td><i class="fa fa-clock-o"></i> 04:10am</td>
                                <td>Amelia</td>
                                <td class="text-navy"> <i class="fa fa-level-up"></i> 66% </td>
                            </tr>
                            <tr>
                                <td><small>Pending...</small> </td>
                                <td><i class="fa fa-clock-o"></i> 12:08am</td>
                                <td>Damian</td>
                                <td class="text-navy"> <i class="fa fa-level-up"></i> 23% </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>