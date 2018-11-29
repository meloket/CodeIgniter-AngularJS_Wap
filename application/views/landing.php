
    <!-- Header with Background Image -->
    <header class="business-header">
      <div class="">
        <div class="">
          <div class="">
            <!-- <img src="<?php echo base_url().'assets/img/land_bg.png'; ?>"/> -->
            <div class="bannerbg"></div>
          </div>
        </div>
      </div>
    </header>
    <!-- Page Content -->
    <div class="container lan_board">

      <div class="row">
        <div class="col-sm-3">
          <span>
            <h4 class="news_mark"><b>平台公告 News</b></h4>
            <button class="btn btn-primary" style="padding:2px;display: inline-block; margin-bottom: 8px; margin-left: 10px">更多+</button>
          </span>
          <div style="color: #f00; padding-left:20px"><b>六合彩第109期特码:04羊(蓝)波</b></div><hr>
          <div style="padding-left:20px;" class="row">
            <div class="col-sm-4">
              <img src="<?php echo base_url().'assets/img/news.png'; ?>">
            </div>
            <div class="col-sm-8">
              <div style="font-size: 13px">六合彩第109期开奖结果:14鸡-20兔-22牛-24猪-05马-48猪+特码:04羊</div>
            </div>
          </div>
          <hr>
          <div class="lismAnnoun">
            <ul class="announbox" style="font-size:15px;list-style-type: none; color:#000">
              <li class="announ"><span>六合彩第108期开奖结果</span></li>
              <li class="announ"><span>中秋佳节，感恩常伴，感恩回馈活动已开启！</span></li>
              <li class="announ"><span>中秋佳节，感恩常伴，感恩回馈活动已开启！</span></li>
              <li class="announ"><span>六合彩第107期开奖结果</span></li>
            </ul>
          </div>
          <span>
            <h4 class="dynamic_mark"><b>投注动态 Dynamic</b></h4>
          </span>
        </div>
        <div class="col-sm-9">
          <span>
            <h4 class="hotgame_mark"><b>热门彩种 Hot Lottery</b></h4>
          </span>
          <div class="row">
            <div class="col-sm-4"><a href="#" data-toggle="modal" data-target="#myModal"><img width=100% src="<?php echo base_url().'assets/img/hot_game1.jpg'; ?>" style="border-radius: 5px;" ></a></div>
            <div class="col-sm-4"><a href="#" data-toggle="modal" data-target="#myModal"><img width=100% src="<?php echo base_url().'assets/img/hot_game2.jpg'; ?>" style="border-radius: 5px;" ></a></div>
            <div class="col-sm-4"><a href="#" data-toggle="modal" data-target="#myModal"><img width=100% src="<?php echo base_url().'assets/img/hot_game3.jpg'; ?>" style="border-radius: 5px;" ></a></div>
          </div>
          <hr>
          <span>
            <h4 class="allgame_mark"><b>全部彩种 All Lotteries</b></h4>
          </span>
          <div class="row allgame">
            <div class="col-sm-4 allgame_item"><a href="#" data-toggle="modal" data-target="#myModal"><img width=100% src="<?php echo base_url().'assets/img/game1.jpg'; ?>" ></a></div>
            <div class="col-sm-4 allgame_item"><a href="#" data-toggle="modal" data-target="#myModal"><img width=100% src="<?php echo base_url().'assets/img/game2.jpg'; ?>" ></a></div>
            <div class="col-sm-4 allgame_item"><a href="#" data-toggle="modal" data-target="#myModal"><img width=100% src="<?php echo base_url().'assets/img/game3.jpg'; ?>" ></a></div>
            <div class="col-sm-4 allgame_item"><a href="#" data-toggle="modal" data-target="#myModal"><img width=100% src="<?php echo base_url().'assets/img/game4.jpg'; ?>" ></a></div>
            <div class="col-sm-4 allgame_item"><a href="#" data-toggle="modal" data-target="#myModal"><img width=100% src="<?php echo base_url().'assets/img/game5.jpg'; ?>" ></a></div>
            <div class="col-sm-4 allgame_item"><a href="#" data-toggle="modal" data-target="#myModal"><img width=100% src="<?php echo base_url().'assets/img/game6.jpg'; ?>" ></a></div>
            <div class="col-sm-4 allgame_item"><a href="#" data-toggle="modal" data-target="#myModal"><img width=100% src="<?php echo base_url().'assets/img/game7.jpg'; ?>" ></a></div>
            <div class="col-sm-4 allgame_item"><a href="#" data-toggle="modal" data-target="#myModal"><img width=100% src="<?php echo base_url().'assets/img/game8.jpg'; ?>" ></a></div>
            <div class="col-sm-4 allgame_item"><a href="#" data-toggle="modal" data-target="#myModal"><img width=100% src="<?php echo base_url().'assets/img/game9.jpg'; ?>" ></a></div>
          </div>
        </div>
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-lg-12">
          <img src="<?php echo base_url().'assets/img/hf.png'; ?>" width=100% />
        </div>
      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog" style="width:60%;top: 20%; right: 20%; bottom: 20%; left: 20%;">
    <div class="modal-dialog">
    <?php echo form_open(site_url('/user/login')); ?>
      <div class="modal-content">
        <div class="modal-body">
          <p><img src="<?php echo base_url().'assets/img/sp_game.png'; ?>" width='50px'/>您还未登录，请先登录</p>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-danger">是</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        </div>
      </div>
    <?php echo form_close(); ?>
    </div>
  </div>

