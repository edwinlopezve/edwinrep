<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 03/05/17
 * Time: 06:48 PM
 *
 * @var $propiedad \App\Models\Propiedad
 */?>
<section id="make-enquiry">
    <div class="container-fluid enquiry-overlay">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-3">

                <div class="enquiry-form">
                    <h2 class="heading">
                        @lang('property_info.make_enquiry.make_an_enquiry') (<?= $propiedad->getLabelDetail() ?>)<br/>
                        <span>@lang('property_info.make_enquiry.property_ref') <?= $propiedad->ref ?></span>
                    </h2>
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

            <div class="col-sm-2">
                <div class="property-by">
                    <p>@lang('property_info.property_featured_by')</p>
                    <a href="#">
                        <div class="company-name">
                            <h3 class="name">
                                Marbella Dream Homes
                            </h3>
                            <div class="img">
                                <img src="{!! asset('assets/images/7648.jpg') !!}" class="img-responsive"/>
                            </div>

                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
