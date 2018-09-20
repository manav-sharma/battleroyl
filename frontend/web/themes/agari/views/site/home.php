<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\db\Query;

$this->title = 'Home';
$siteimage = Yii::getAlias('@siteimage');
$banner = Yii::$app->frontendmethods->frontendbanner();
?>
  <section id="mainContent">
    <section class="bannerOuter">
	   <ul class="bxslider">
		<?php foreach($banner as $bval) { ?>   
		<li> <img src="<?php echo BANNER_IMAGE_PATH.'/'.$bval['bannerImage']; ?>" alt="" />
		  <div class="container">
			<div class="row">
			  <div class="col-xs-12">
				<div class="bannerText">
				<h1><?php echo $bval['title']; ?></h1>
				<span><?php echo $bval['title']; ?> SAR 19,500</span>
				<p><?php echo $bval['description']; ?></p>
				<a class="readmorenews" href="index.php">Read more</a> </div>
			  </div>
			</div>
		  </div></li>
		   <?php } ?>
		</ul>
    </section>
    <section class="mapOuter"> <img src="<?php echo $siteimage;?>/map.jpg" alt=""> </section>
    <section class="yellowBlock">
      <div class="container">
        <div class="border">
          <div class="row">
            <div class="col-md-2 col-sm-4 col-xs-6 full">
              <div class="selectBox">
                <select>
					<option>Property Type</option>
					<option>Flats</option>
					<option>Villas</option>
					<option>Duplexes</option>
					<option>Single Floors</option>
					<option>Compounds</option>
					<option>Furnished Flats</option>
                </select>
              </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 full">
              <div class="selectBox">
                <select>
                  <option>Select Property </option>
                  <option>Sale</option>
                  <option>Rent</option>
                  <option>Investment</option>
                  <option>Exchange</option>
                </select>
              </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 full">
              <div class="selectBox selectregion"> <i class="fa fa-map-marker" aria-hidden="true"></i>
                <select>
                  <option>Select Country</option>
                  <option>Saudi Arabia</option>
                  <option>United Arab Emirates</option>
                  <option>Qatar</option>
                  <option>Bahrain</option>
                   <option>Kuwait</option>
                    <option>Oman</option>
                </select>
              </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 full">
              <div class="selectBox">
                <select>
                  <option>Select Region</option>
                  <option>Riyadh</option>
                  <option>Tabuk</option>
                  <option>Madinah</option>
                  <option>Makkah</option>
                  <option>Tehran</option>
                  <option>Mashhad</option>
                </select>
              </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 full">
              <div class="selectBox">
                <select>
                  <option>Select City</option>
                  <option>Dubai</option>
                  <option>Sharjah</option>
                  <option>Abu Dhabi</option>
                  <option>Ajman</option>
                </select>
              </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 full">
              <div class="sel"><a class="readmorenews" href="search.php">Search</a> <span>Advanced Search</span></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="slidebox">
              <div class="marg20">
                <div class="row">
                  <div class="col-md-3">
                    <label>Area</label>
                    <div class="left">
                      <input type="text">
                      <span class="stext">From m<sup>2</sup></span> </div>
                    <div class="right">
                      <input type="text">
                      <span class="stext">To m<sup>2</sup></span> </div>
                  </div>
                  <div class="col-md-3">
                    <label>No. of Rooms</label>
                    <div class="left">
                      <div class="selectBox">
                        <select>
                          <option></option>
                          <option>1</option>
                          <option>2</option>
                        </select>
                      </div>
                      <span class="stext">From</span> </div>
                    <div class="right">
                      <div class="selectBox">
                        <select>
                          <option></option>
                          <option>1</option>
                          <option>2</option>
                        </select>
                      </div>
                      <span class="stext">To</span> </div>
                  </div>
                  <div class="col-md-3">
                    <label>Floors</label>
                    <div class="left">
                      <div class="selectBox">
                        <select>
                          <option></option>
                          <option>1</option>
                          <option>2</option>
                        </select>
                      </div>
                      <span class="stext">From</span> </div>
                    <div class="right">
                      <div class="selectBox">
                        <select>
                          <option></option>
                          <option>1</option>
                          <option>2</option>
                        </select>
                      </div>
                      <span class="stext">To</span> </div>
                  </div>
                  <div class="col-md-3">
                    <label>Price Range</label>
                    <div class="left">
                      <div class="selectBox">
                        <select>
                          <option></option>
                          <option>100</option>
                          <option>200</option>
                        </select>
                      </div>
                      <span class="stext">From</span> </div>
                    <div class="right">
                      <div class="selectBox">
                        <select>
                          <option></option>
                          <option>100</option>
                          <option>200</option>
                        </select>
                      </div>
                      <span class="stext">To</span> </div>
                  </div>
                </div>
              </div>
              <div class="marg20">
                <div class="row">
                  <div class="col-md-3">
                    <label>Build Year</label>
                    <div class="left">
                      <div class="selectBox">
                        <select>
                          <option></option>
                          <option>100</option>
                          <option>200</option>
                        </select>
                      </div>
                      <span class="stext">From</span> </div>
                    <div class="right">
                      <div class="selectBox">
                        <select>
                          <option></option>
                          <option>100</option>
                          <option>200</option>
                        </select>
                      </div>
                      <span class="stext">To</span> </div>
                  </div>
                  <div class="col-md-3">
                    <label>View results:</label>
                    <div class="checkboxBlock">
                      <input type="checkbox" >
                      <span>With Video, 3D, 360 Degree Views</span></div>
                    <div class="checkboxBlock">
                      <input type="checkbox" >
                      <span>With Photos</span></div>
                    <div class="checkboxBlock">
                      <input type="checkbox" >
                      <span>From Owners</span></div>
                  </div>
                  <div class="col-md-6">
                    <label>From:</label>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="checkboxBlock">
                          <input type="checkbox" >
                          <span>Agencies</span></div>
                        <div class="checkboxBlock">
                          <input type="checkbox" >
                          <span>Builders</span></div>
                        <div class="checkboxBlock">
                          <input type="checkbox" >
                          <span>Public entities such as Ministry of Housing</span></div>
                      </div>
                      <div class="col-md-4">
                        <div class="checkboxBlock">
                          <input type="checkbox" >
                          <span>Brokers</span></div>
                        <div class="checkboxBlock">
                          <input type="checkbox" >
                          <span>Developers</span></div>
                        <div class="checkboxBlock">
                          <input type="checkbox" >
                          <span>Affordable Housing Associations</span></div>
                      </div>
                      <div class="col-md-4">
                        <div class="checkboxBlock">
                          <input type="checkbox" >
                          <span>Foundations</span></div>
                        <div class="checkboxBlock">
                          <input type="checkbox" >
                          <span>Charities</span></div>
                        <div class="checkboxBlock">
                          <input type="checkbox" >
                          <span>Limited Income Support Programs</span></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="centered">
              <div class="toggle"><span class="more">See more option <i class="fa fa-angle-double-down" aria-hidden="true"></i></span><span class="less">See less option <i class="fa fa-angle-double-up" aria-hidden="true"></i></span></div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="newListing">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <div class="centeredText"><span>New listings</span></div>
          </div>
        </div>
        <div class="row">
          <div class="listingImg">
            <div class="threeCol">
              <div class="col-md-5 col-sm-5 col-xs-5 fullBlock"><a href="property-detail.php"><img src="<?php echo $siteimage;?>/img01.jpg" alt="">
                <div class="heart"> <span class="blankheart"><img src="<?php echo $siteimage;?>/heart.png" alt=""></span> <span class="fillheart"><img src="<?php echo $siteimage;?>/fillheart.png" alt=""></span> </div>
                <div class="text">
                  <div class="ratings"> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star grey" aria-hidden="true"></i> </div>
                  <h6>SAR 25,000</h6>
                  <p>Water Park Towers </p>
                  <p>Golden Valley, MN 55427</p>
                </div>
                </a></div>
              <div class="col-md-3 col-sm-3 col-xs-3 fullBlock"><a href="property-detail.php"><img src="<?php echo $siteimage;?>/img02.jpg" alt="">
                <div class="heart"> <span class="blankheart"><img src="<?php echo $siteimage;?>/heart.png" alt=""></span> <span class="fillheart"><img src="<?php echo $siteimage;?>/fillheart.png" alt=""></span> </div>
                <div class="text">
                  <div class="ratings"> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star grey" aria-hidden="true"></i> </div>
                  <h6>SAR 25,000</h6>
                  <p>Water Park Towers </p>
                  <p>Golden Valley, MN 55427</p>
                </div>
                </a></div>
              <div class="col-md-4 col-sm-4 col-xs-4 fullBlock"><a href="property-detail.php"><img src="<?php echo $siteimage;?>/img03.jpg" alt="">
                <div class="heart"> <span class="blankheart"><img src="<?php echo $siteimage;?>/heart.png" alt=""></span> <span class="fillheart"><img src="<?php echo $siteimage;?>/fillheart.png" alt=""></span> </div>
                <div class="text">
                  <div class="ratings"> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star grey" aria-hidden="true"></i> </div>
                  <h6>SAR 25,000</h6>
                  <p>Water Park Towers </p>
                  <p>Golden Valley, MN 55427</p>
                </div>
                </a></div>
            </div>
            <div class="threeCol">
              <div class="col-md-4 col-sm-4 col-xs-4 fullBlock"><a href="property-detail.php"><img src="<?php echo $siteimage;?>/img04.jpg" alt="">
                <div class="heart"> <span class="blankheart"><img src="<?php echo $siteimage;?>/heart.png" alt=""></span> <span class="fillheart"><img src="<?php echo $siteimage;?>/fillheart.png" alt=""></span> </div>
                <div class="text">
                  <div class="ratings"> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star grey" aria-hidden="true"></i> </div>
                  <h6>SAR 25,000</h6>
                  <p>Water Park Towers </p>
                  <p>Golden Valley, MN 55427</p>
                </div>
                </a></div>
              <div class="col-md-3 col-sm-3 col-xs-3 fullBlock"><a href="property-detail.php"><img src="<?php echo $siteimage;?>/img05.jpg" alt="">
                <div class="heart"> <span class="blankheart"><img src="<?php echo $siteimage;?>/heart.png" alt=""></span> <span class="fillheart"><img src="<?php echo $siteimage;?>/fillheart.png" alt=""></span> </div>
                <div class="text">
                  <div class="ratings"> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star grey" aria-hidden="true"></i> </div>
                  <h6>SAR 25,000</h6>
                  <p>Water Park Towers </p>
                  <p>Golden Valley, MN 55427</p>
                </div>
                </a></div>
              <div class="col-md-5 col-sm-5 col-xs-5 fullBlock"><a href="property-detail.php"><img src="<?php echo $siteimage;?>/img06.jpg" alt="">
                <div class="heart"> <span class="blankheart"><img src="<?php echo $siteimage;?>/heart.png" alt=""></span> <span class="fillheart"><img src="<?php echo $siteimage;?>/fillheart.png" alt=""></span> </div>
                <div class="text">
                  <div class="ratings"> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star" aria-hidden="true"></i> <i class="fa fa-star grey" aria-hidden="true"></i> </div>
                  <h6>SAR 25,000</h6>
                  <p>Water Park Towers </p>
                  <p>Golden Valley, MN 55427</p>
                </div>
                </a></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="centeredLink"> <a href="property-listing.php" class="readmorenews">EXPLORE MORE</a> </div>
          </div>
        </div>
      </div>
    </section>
    <section class="categoreis">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <div class="centeredText"><span>Categories</span></div>
          </div>
        </div>
        <div class="row">
          <div class="imagesBlock">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row">
                <div class="threeCol">
                  <div class="col-md-5 col-sm-5 col-xs-5 fullBlock">
                    <div class="catBlock"> <a href="category-detail.php">
                      <div class="catThumb"><img src="<?php echo $siteimage;?>/category01.jpg" alt=""></div>
                      <div class="catDesc">Apartments</div>
                      </a> </div>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3 fullBlock">
                    <div class="catBlock"><a href="category-detail.php">
                      <div class="catThumb"><img src="<?php echo $siteimage;?>/category02.jpg" alt=""></div>
                      <div class="catDesc">Villas</div>
                      </a> </div>
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-4 fullBlock">
                    <div class="catBlock last"><a href="category-detail.php">
                      <div class="catThumb"><img src="<?php echo $siteimage;?>/category03.jpg" alt=""></div>
                      <div class="catDesc">Single Floors</div>
                      </a> </div>
                  </div>
                </div>
                <div class="threeCol">
                  <div class="col-md-4 col-sm-4 col-xs-4 fullBlock">
                    <div class="catBlock last"><a href="category-detail.php">
                      <div class="catThumb"><img src="<?php echo $siteimage;?>/category04.jpg" alt=""></div>
                      <div class="catDesc">Offices</div>
                      </a> </div>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3 fullBlock">
                    <div class="catBlock"><a href="category-detail.php">
                      <div class="catThumb"><img src="<?php echo $siteimage;?>/category05.jpg" alt=""></div>
                      <div class="catDesc">Building</div>
                      </a> </div>
                  </div>
                  <div class="col-md-5 col-sm-5 col-xs-5 fullBlock">
                    <div class="catBlock last"><a href="category-detail.php">
                      <div class="catThumb"><img src="<?php echo $siteimage;?>/category06.jpg" alt=""></div>
                      <div class="catDesc">Furnished Flats</div>
                      </a> </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="centeredLink"> <a href="categories.php" class="readmorenews">EXPLORE MORE</a> </div>
          </div>
        </div>
      </div>
    </section>
    <section class="thumbBlocks">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <div class="centeredText"><span>International</span></div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12 ">
            <div class="largeThumb"><a href="international.php"> <img src="<?php echo $siteimage;?>/unitedarab.jpg" alt="">
              <div class="captiontext">United Arab <br>
                Emirates</div>
              </a></div>
          </div>
          <div class="col-md-4 col-sm-4 col-xs-6 full">
            <div class="smallThumb"><a href="international.php"><img src="<?php echo $siteimage;?>/bahrain.jpg" alt="">
              <div class="captiontext">Bahrain</div>
              </a></div>
            <div class="smallThumb last"><a href="international.php"><img src="<?php echo $siteimage;?>/qatar.jpg" alt="">
              <div class="captiontext">Qatar</div>
              </a></div>
          </div>
          <div class="col-md-4 col-sm-4 col-xs-6 full">
            <div class="smallThumb"><a href="international.php"><img src="<?php echo $siteimage;?>/kuwait.jpg" alt="">
              <div class="captiontext">Kuwait</div>
              </a></div>
            <div class="smallThumb last"><a href="international.php"><img src="<?php echo $siteimage;?>/egypt.jpg" alt="">
              <div class="captiontext">Egypt</div>
              </a></div>
          </div>
        </div>
      </div>
    </section>
    <section class="ksaOuter">
    	<div class="container">
        	<div class="row">
            	<div class="col-xs-12">
                	<h3>Maximum Business Results For KSA</h3>
                </div>
            </div>
        	<div class="row">
            	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 widthBlock">
                	<div class="saleBlock">
                    	<div class="saleIcon">
                        	<img class="img-responsive" src="<?php echo $siteimage;?>/ksa1.png" alt="">
                        </div>
                        <div class="saleText">
                        	<h1>300,000+</h1>
                            <span>Property For Sale</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 widthBlock">
                	<div class="saleBlock">
                    	<div class="saleIcon">
                        	<img class="img-responsive" src="<?php echo $siteimage;?>/ksa2.png" alt="">
                        </div>
                        <div class="saleText">
                        	<h1>170,000+</h1>
                            <span>Property For Rent</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 widthBlock">
                	<div class="saleBlock">
                    	<div class="saleIcon">
                        	<img class="img-responsive" src="<?php echo $siteimage;?>/ksa3.png" alt="">
                        </div>
                        <div class="saleText">
                        	<h1>10,000+</h1>
                            <span>Property For Exchange</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 widthBlock">
                	<div class="saleBlock">
                    	<div class="saleIcon">
                        	<img class="img-responsive" src="<?php echo $siteimage;?>/ksa4.png" alt="">
                        </div>
                        <div class="saleText">
                        	<h1>15,000+</h1>
                            <span>Property For Investment</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 widthBlock">
                	<div class="saleBlock">
                    	<div class="saleIcon">
                        	<img class="img-responsive" src="<?php echo $siteimage;?>/ksa5.png" alt="">
                        </div>
                        <div class="saleText">
                        	<h1>40,000</h1>
                            <span>Ejar Offers</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 widthBlock">
                	<div class="saleBlock">
                    	<div class="saleIcon">
                        	<img class="img-responsive" src="<?php echo $siteimage;?>/ksa6.png" alt="">
                        </div>
                        <div class="saleText">
                        	<h1>100,000+</h1>
                            <span>Agents Offers</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 widthBlock">
                	<div class="saleBlock saleMargin">
                    	<div class="saleIcon">
                        	<img class="img-responsive" src="<?php echo $siteimage;?>/ksa7.png" alt="">
                        </div>
                        <div class="saleText">
                        	<h1>10,000+</h1>
                            <span>Monthly Searches</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 widthBlock">
                	<div class="saleBlock saleMargin">
                    	<div class="saleIcon">
                        	<img class="img-responsive" src="<?php echo $siteimage;?>/ksa8.png" alt="">
                        </div>
                        <div class="saleText">
                        	<h1>100,000+</h1>
                            <span>Monthly Visits</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 widthBlock">
                	<div class="saleBlock saleMargin">
                    	<div class="saleIcon">
                        	<img class="img-responsive" src="<?php echo $siteimage;?>/ksa9.png" alt="">
                        </div>
                        <div class="saleText">
                        	<h1>200,000+</h1>
                            <span>Monthly Page Hits</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="newsBlock">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-sm-8">
            <div class="row">
              <div class="col-xs-12">
                <div class="thead"><span>NEWS</span></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-6 full">
                <div class="newsThumb"><img src="<?php echo $siteimage;?>/news01.jpg" alt=""></div>
                <div class="desc">
                  <div class="date">22 Nov, 2016</div>
                  <div class="title">Lorem ipsum sir dolor</div>
                  <p>Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio </p>
                  <a class="readmore" href="news-detail.php">Read more</a> </div>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-6 full">
                <div class="newsThumb"><img src="<?php echo $siteimage;?>/news02.jpg" alt=""></div>
                <div class="desc">
                  <div class="date">22 Nov, 2016</div>
                  <div class="title">Lorem ipsum sir dolor</div>
                  <p>Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio </p>
                  <a class="readmore" href="news-detail.php">Read more</a> </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <div class="topBorder"> <a href="news.php" class="readmorenews">Read more news</a> </div>
              </div>
            </div>
          </div>
          <div class="col-md-4  col-sm-4 col-xs-12">
          <?php  //include('sidebar-services.php'); ?> 
          </div>
        </div>
      </div>
    </section>
  </section>
