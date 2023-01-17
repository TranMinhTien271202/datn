@extends('client.layout.app')
@section('title')
    {{__('Candi')}}
@endsection
@section('content')
    <section class="page-title style-two">
        <div class="auto-container">
            <div class="job-search-form">
                <form method="post" action="https://creativelayers.net/themes/superio/job-list-v10.html">
                    <div class="row">
                        <!-- Form Group -->
                        <div class="form-group col-lg-4 col-md-12 col-sm-12">
                            <span class="icon flaticon-search-1"></span>
                            <input type="text" name="field_name" placeholder="Job title, keywords, or company">
                        </div>

                        <!-- Form Group -->
                        <div class="form-group col-lg-3 col-md-12 col-sm-12 location">
                            <span class="icon flaticon-map-locator"></span>
                            <input type="text" name="field_name" placeholder="City or postcode">
                        </div>

                        <!-- Form Group -->
                        <div class="form-group col-lg-3 col-md-12 col-sm-12 location">
                            <span class="icon flaticon-briefcase"></span>
                            <select class="chosen-select">
                                <option value="">All Categories</option>
                                <option value="44">Accounting / Finance</option>
                                <option value="106">Automotive Jobs</option>
                                <option value="46">Customer</option>
                                <option value="48">Design</option>
                                <option value="47">Development</option>
                                <option value="45">Health and Care</option>
                                <option value="105">Marketing</option>
                                <option value="107">Project Management</option>
                            </select>
                        </div>

                        <!-- Form Group -->
                        <div class="form-group col-lg-2 col-md-12 col-sm-12 text-right">
                            <button type="submit" class="theme-btn btn-style-one">Find Jobs</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Job Search Form -->
        </div>
    </section>
    <!--End Page Title-->

    <!-- Listing Section -->
    <section class="ls-section">
        <div class="auto-container">
            <div class="filters-backdrop"></div>

            <div class="row">
                <!-- Content Column -->
                <div class="content-column col-lg-12">
                    <div class="ls-outer">
                        <!-- ls Switcher -->
                        <div class="ls-switcher">
                            <div class="showing-result">
                                <div class="top-filters">
                                    <div class="form-group">
                                        <select class="chosen-select">
                                            <option>Candidate Gender</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                            <option>other</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <select class="chosen-select">
                                            <option>Date Posted</option>
                                            <option>New Jobs</option>
                                            <option>Freelance</option>
                                            <option>Full Time</option>
                                            <option>Internship</option>
                                            <option>Part Time</option>
                                            <option>Temporary</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <select class="chosen-select">
                                            <option>Experience Level</option>
                                            <option>New Jobs</option>
                                            <option>Freelance</option>
                                            <option>Full Time</option>
                                            <option>Internship</option>
                                            <option>Part Time</option>
                                            <option>Temporary</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <select class="chosen-select">
                                            <option>Education Level</option>
                                            <option>New Jobs</option>
                                            <option>Freelance</option>
                                            <option>Full Time</option>
                                            <option>Internship</option>
                                            <option>Part Time</option>
                                            <option>Temporary</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="sort-by">
                                <select class="chosen-select">
                                    <option>Most Recent</option>
                                    <option>Freelance</option>
                                    <option>Full Time</option>
                                    <option>Internship</option>
                                    <option>Part Time</option>
                                    <option>Temporary</option>
                                </select>

                                <select class="chosen-select">
                                    <option>Show 10</option>
                                    <option>Show 20</option>
                                    <option>Show 30</option>
                                    <option>Show 40</option>
                                    <option>Show 50</option>
                                    <option>Show 60</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Candidate block Four -->
                            @foreach ($data as $item)
                            <div class="candidate-block-four col-lg-4 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <ul class="job-other-info">
                                        <li class="green">Featured</li>
                                    </ul>
                                    <span class="thumb"><img src="{{asset($item->avatar)}}" alt=""></span>
                                    <h3 class="name"><a href="#">{{$item->name}}</a></h3>
                                    <span class="cat">UI Designer</span>
                                    <ul class="job-info">
                                        <li><span class="icon flaticon-map-locator"></span> {{$item->address}}</li>
                                        <li><span class="icon flaticon-money"></span> $99 / hour</li>
                                    </ul>
                                    <ul class="post-tags">
                                        <li><a href="#">App</a></li>
                                        <li><a href="#">Design</a></li>
                                        <li><a href="#">Digital</a></li>
                                    </ul>
                                    <a href="#" class="theme-btn btn-style-three">View Profile</a>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <nav class="ls-pagination">
                            <ul>
                                <li class="prev"><a href="#"><i class="fa fa-arrow-left"></i></a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#" class="current-page">2</a></li>
                                <li><a href="#">3</a></li>
                                <li class="next"><a href="#"><i class="fa fa-arrow-right"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
