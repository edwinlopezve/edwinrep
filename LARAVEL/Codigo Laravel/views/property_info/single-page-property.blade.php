<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 03/05/17
 * Time: 06:45 PM
 *
 *  @var $propiedad \App\Models\Propiedad
 */?>
<section id="single-page-property">

    <div class="container-fluid">
        <div id="main_area">
            <!-- Slider -->
            <div class="row">
                <div class="col-xs-12" id="slider">
                    <!-- Top part of the slider -->
                    <div class="row">
						<?php
							$users = DB::table('usuarios_detalles')->where('usuario_id', $propiedad->usuario_id)->get();
							$users_img = DB::table('usuarios')->where('id_usuario', $propiedad->usuario_id)->get();
							//$users = DB::table('usuarios_detalles')->where('usuario_id', $propiedad->usuario_id)->get();
							//print_r($users[0]->empresa);
						?>
                        <div class="col-md-8">
                            <div id="carousel-bounding-box">
                                <div class="carousel slide" id="myCarousel">
                                    <!-- Carousel items -->
                                    <div class="carousel-inner">
                                        <?php $count = 0; ?>
                                        <?php foreach ($propiedad->getImages() as $img) : ?>
                                            <div class="<?php echo $count == 0 ? 'active ' : '' ?> item" data-slide-number="0">
                                                <img src="<?= $img->img_url ?>">
                                            </div>
                                            <?php $count++; ?>
                                        <?php endforeach; ?>
                                    </div><!-- Carousel nav -->
                                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                    </a>
                                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                    </a>
                                </div>

                                <div class="details-product">
                                    <div class="details-room">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-sm-6">
                                                <div class="text-center">
                                                    <p>@lang('property_info.single_page.bedrooms')</p>
                                                    <p><?= $propiedad->getBeds() ?></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6">
                                                <div class="text-center">
                                                    <p>@lang('property_info.single_page.bathrooms')</p>
                                                    <p><?= $propiedad->getBaths() ?></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6">
                                                <div class="text-center">
                                                    <p>@lang('property_info.single_page.pool')</p>
                                                    <p><i class="<?= $propiedad->hasPool() ?>"></i></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-6">
                                                <div class="text-center">
                                                    <p>@lang('property_info.single_page.build_size')</p>
                                                    <p><?= $propiedad->getBuilt() ?> m²</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--- details room --->
                                    <div class="row descriptions">
                                        <div class="col-md-12">
											<?php 
											$value=$propiedad->getDescription();
											$val=$value->toArray();
										?>
                                            <p class="pro-description"><?= $val['catalan'];?></p>
										
                                         </div>
                                        @if($propiedad->getFeatures() != null)
                                            @foreach($propiedad->getFeatures() as $feature)
                                                <div class="col-md-6"><?= $feature->feat_name ?></div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <p class="fvrt-btn-text">
                                        <button class="btn btn-default fvrt-btn"><i class="fa fa-star"></i>@lang('property_info.single_page.add_to_favorites')</button>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4" id="carousel-text">

                            <div id="slide-content">
                                <div id="slide-inner-content">
                                    <div class="header">
                                        <div class="img">
												@if(count($users_img) > 0)
													<img src="https://pisos.click/admin/public/uploads/profile/<?php echo $users_img[0]->imagen?>" class="img-responsive" />													
												@else												
													<img src="{!! asset('assets/images/7648.jpg') !!}" class="img-responsive" />														
												@endif
												@if(count($users) > 0)
													<p><?= $users[0]->empresa; ?></p>
												@else	
													<p>Marbella Dream Homes</p>
												@endif
                                        </div>
                                    </div>
                                    <div class="company">
                                        <a href="#">
                                            <div class="name">
                                                <h2>@lang('property_info.make_enquiry.make_an_enquiry')</h2>
                                                <p>@lang('property_info.make_enquiry.property_ref') <?= $propiedad->ref ?></p>

                                            </div>
                                        </a>
                                    </div>

                                    <div class="forms">
                                        <form action="/sendEnquiry" method="post">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="@lang('property_info.make_enquiry.name')">
                                            </div>
                                            <div class="form-group">
                                                <input type="email" class="form-control" id="email" name="email" placeholder="@lang('property_info.make_enquiry.email')">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="number" name="number" placeholder="@lang('property_info.make_enquiry.number')">
                                            </div>
                                            <div class="form-group">
                                                <textarea rows="5" class="form-control" id="message" name="message" placeholder="@lang('property_info.make_enquiry.message')"></textarea>
                                            </div>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-default enqry-btn">@lang('property_info.make_enquiry.send_enquiry')</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--/Slider-->
        </div>
    </div>
</section>
