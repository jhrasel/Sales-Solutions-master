<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Solution</title>


    <link rel="icon" href="{{ asset('landing/images/Logo.png') }}">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

    <!-- swiper  -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"
    />


    <!-- CSS Link -->
    <link rel="stylesheet" href="{{ asset('landing/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/media.css') }}">

    <style>
        html,
        body {
            position: relative;
            height: 100%;
        }

        body {
            background: #eee;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .swiper {
            width: 100%;
            padding-top: 50px;
            padding-bottom: 50px;
        }

        .swiper-slide {
            background-position: center;
            background-size: cover;
            width: 300px;
            height: 300px;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
        }
    </style>

</head>

<body onload="myFunction()">

<div id="loading"></div >

<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------
    START Header PART
---------------------------------------------------------------------------------------------------------------------------------------------------  -->
<section id="header">
    <div class="container">
        <!-- navbar part  -->
        <div class="navbar_header">
            <nav class="navbar navbar-expand-lg ">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img src="{{ asset('landing/images/logo.png') }}" alt="">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mx-auto mb-2 mb-lg-0 ml-lg-4">
                            <li class="nav-item">
                                <a class="nav-link active me-3" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link me-3" href="#">Feature</a>
                            </li>

                            <li class="nav-item ">
                                <a class="nav-link me-3" href="#">Themes</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link ml-3" href="#">Pricing</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link ml-3" href="#">Blogs</a>
                            </li>


                        </ul>
                        <div class="login_button">
                            <form class="container-fluid justify-content-start">
                                <a class="btn btn-outline-success me-2" type="button" href="javascript:;">Login</a>
                                <a class="btn btn-outline-success me-2" type="button" href="{{ route('merchant.register') }}">Sign Up</a>
                                <!-- <a class="Sign_Up_bg" href=""> <button>Sign Up</button></a> -->
                            </form>
                        </div>

                    </div>
                </div>
            </nav>
        </div>

        <!-- header text   -->
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="header_text_contain">
                    <h2>Create Your <span>Own Online Shop,</span>
                        Decorate Your Shop, <span>Boost Up Your Sales !</span></h2>

                    <h4>With Help Of <span>SaleSolution</span> </h4>
                    <h3>Transform Your Business To <span>E-Commerce Instantly</span></h3>

                </div>
            </div>
        </div>



    </div>
    <div class="container-fluid">
        <!-- banner image  -->
        <div class="row">
            <div class="col-lg-10 ">
                <div class="banner_image">
                    <img class="img-fluid" src="{{ asset('landing/images/banner.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>



</section>


<!-- Sections Gaps -->
<div class="section_gaps"></div>

<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------
    online shop  PART
---------------------------------------------------------------------------------------------------------------------------------------------------  -->
<section id="online_shop">
    <div class="container">
        <!-- online shop header  -->
        <div class="row">
            <div class="col-lg-12 m-auto">
                <div class="online_shop_contain">
                    <h2>How To <span>Set Up Your Online Shop</span></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eget proin aliquet eget massa quis mi netus mi. Morbi sed id amet faucibus dolor, auctor. Pulvinar vitae risus leo.</p>
                    <img class="img-fluid" src="{{ asset('landing/images/info-5 (1).png')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Sections Gaps -->
<div class="section_gaps"></div>

<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------
    Feather  PART
---------------------------------------------------------------------------------------------------------------------------------------------------  -->

<section id="shop_feature">
    <div class="container">
        <div class="row">
            <!-- item 1 -->
            <div class="col-lg-7">
                <!-- right banner image  -->
                <div class="left_feature_banner">
                    <img class="img-fluid" src="{{ asset('landing/images/feather_banner.png')}}" alt="">
                </div>
            </div>
            <!-- item end  -->

            <!-- item 2 -->
            <div class="col-lg-5">
                <div class="right_text_feature">
                    <div class="feature_list_header">
                        <h2>Best Features That<br>
                            Will Make <span>Your Shop Best</span></h2>
                    </div>
                    <div class="feature-list">
                        <ul>
                            <li>Easy & Smart Dashboard</li>
                            <li>Instant Shop Creation</li>
                            <li>Easy Shop Management</li>
                            <li>Smart Analytics Report</li>
                            <li>Effecient Order Management</li>
                            <li>Quick Courier Setup</li>
                            <li>Multiple Payment Method</li>
                            <li>Vast Collection Of Themes</li>
                            <li>Smart Customer Management</li>
                            <li>Plugins For Better Control</li>
                            <li>24/7 Support</li>
                            <li>Easy Product Stock Update</li>
                        </ul>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------
    Manage  shop  PART
---------------------------------------------------------------------------------------------------------------------------------------------------  -->

<section id="manage_shop">
    <div class="container">
        <!-- mange shop left part  -->
        <div class="row">
            <div class="col-lg-8">
                <div class="manage_shop_text">
                    <h2>Manage Your Shop On The Go<br>With <span>Mobile Friendly Application</span></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Fusce eget proin aliquet eget massa quis mi netus mi.
                        Morbi sed id amet faucibus dolor, auctor. Pulvinar vitae
                        risus leo.
                        aliquet nunc sodales commodo nec. Dictum ornare ut
                        ullamcorper eleifend. Non sed suspendisse ullamcorper
                        ultrices elementum.
                    </p>

                    <div class="manage_shop_card">
                        <div class="row">
                            <!-- item  -->
                            <div class="col-lg-3 col-sm-6">
                                <!-- item  -->
                                <div class="manage_shop_card-item">
                                    <svg width="50" height="49" viewBox="0 0 50 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M43.9692 0H6.17333C3.20366 0 0.773926 2.42973 0.773926 5.3994V43.1952C0.773926 46.1649 3.20366 48.5946 6.17333 48.5946H43.9692C46.9388 48.5946 49.3686 46.1649 49.3686 43.1952V5.3994C49.3686 2.42973 46.9388 0 43.9692 0ZM6.17333 43.1952V5.3994H22.3715V43.1952H6.17333ZM43.9692 43.1952H27.7709V24.2973H43.9692V43.1952ZM43.9692 18.8979H27.7709V5.3994H43.9692V18.8979Z" fill="white"/>
                                    </svg>
                                    <h5>Smart Dashboard</h5>
                                </div>
                            </div>
                            <!-- item end  -->

                            <!-- item  -->
                            <div class="col-lg-3 col-sm-6">
                                <!-- item  -->
                                <div class="manage_shop_card-item">
                                    <svg width="29" height="47" viewBox="0 0 29 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M28.3608 0H9.95377L0.750244 25.3097H9.95377L5.35201 46.0176L26.0599 16.1062H14.567L28.3608 0Z" fill="white"/>
                                    </svg>
                                    <h5>Fast Browsing</h5>
                                </div>
                            </div>
                            <!-- item end  -->

                            <!-- item  -->
                            <div class="col-lg-3 col-sm-6">
                                <!-- item  -->
                                <div class="manage_shop_card-item">
                                    <svg width="50" height="49" viewBox="0 0 50 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M45.7599 25.967V34.6227H4.21252V6.92444H21.5239V3.46216H4.21252C3.29427 3.46216 2.41363 3.82693 1.76432 4.47624C1.11502 5.12554 0.750244 6.00618 0.750244 6.92444V34.6227C0.750244 35.5409 1.11502 36.4216 1.76432 37.0709C2.41363 37.7202 3.29427 38.085 4.21252 38.085H18.0616V45.0095H11.1371V48.4718H38.8353V45.0095H31.9108V38.085H45.7599C46.6781 38.085 47.5588 37.7202 48.2081 37.0709C48.8574 36.4216 49.2222 35.5409 49.2222 34.6227V25.967H45.7599ZM28.4485 45.0095H21.5239V38.085H28.4485V45.0095Z" fill="white"/>
                                        <path d="M49.2223 13.8491V10.3868H45.5852C45.3619 9.30318 44.9316 8.27279 44.318 7.35215L46.8974 4.77275L44.4495 2.32492L41.8701 4.90432C40.9495 4.29065 39.9191 3.86039 38.8354 3.63712V0H35.3732V3.63712C34.2895 3.86039 33.2591 4.29065 32.3385 4.90432L29.7591 2.32492L27.3112 4.77275L29.8906 7.35215C29.277 8.27279 28.8467 9.30318 28.6235 10.3868H24.9863V13.8491H28.6235C28.8467 14.9328 29.277 15.9632 29.8906 16.8838L27.3112 19.4632L29.7591 21.911L32.3385 19.3316C33.2591 19.9453 34.2895 20.3756 35.3732 20.5988V24.236H38.8354V20.5988C39.9191 20.3756 40.9495 19.9453 41.8701 19.3316L44.4495 21.911L46.8974 19.4632L44.318 16.8838C44.9316 15.9632 45.3619 14.9328 45.5852 13.8491H49.2223ZM37.1043 17.3114C36.0771 17.3114 35.0731 17.0068 34.219 16.4362C33.3649 15.8655 32.6993 15.0544 32.3062 14.1054C31.9131 13.1564 31.8103 12.1122 32.0107 11.1048C32.2111 10.0974 32.7057 9.17199 33.432 8.44568C34.1583 7.71936 35.0837 7.22474 36.0911 7.02435C37.0985 6.82396 38.1428 6.92681 39.0917 7.31989C40.0407 7.71296 40.8518 8.37862 41.4225 9.23267C41.9931 10.0867 42.2977 11.0908 42.2977 12.118C42.2964 13.4949 41.7487 14.8151 40.7751 15.7888C39.8014 16.7624 38.4813 17.31 37.1043 17.3114V17.3114Z" fill="white"/>
                                    </svg>
                                    <h5>Easy Website Management</h5>
                                </div>
                            </div>
                            <!-- item end  -->


                            <!-- item  -->
                            <div class="col-lg-3 col-sm-6">
                                <!-- item  -->
                                <div class="manage_shop_card-item">
                                    <svg width="54" height="44" viewBox="0 0 54 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M27.6947 37.3893H27.9939V40.3805C27.9939 40.4553 27.9654 40.5282 27.9039 40.5897C27.8425 40.6511 27.7695 40.6796 27.6947 40.6796H19.6809C19.8852 40.1608 19.9928 39.6037 19.9928 39.0358C19.9928 38.4669 19.8848 37.9089 19.6799 37.3893H27.6947ZM27.9939 2.99115H27.6947H3.46645H3.16733V2.69203C3.16733 2.61722 3.19578 2.5443 3.25725 2.48283C3.31872 2.42136 3.39163 2.39292 3.46645 2.39292H27.6947C27.7695 2.39292 27.8425 2.42136 27.9039 2.48283C27.9654 2.5443 27.9939 2.61722 27.9939 2.69203V2.99115ZM3.16733 40.3805V37.3893H3.46645H11.3312C11.1245 37.9133 11.0182 38.4719 11.0182 39.0358C11.0182 39.5988 11.1241 40.1564 11.3301 40.6796H3.46645C3.39163 40.6796 3.31872 40.6511 3.25725 40.5897C3.19578 40.5282 3.16733 40.4553 3.16733 40.3805Z" stroke="white" stroke-width="4.78583"/>
                                        <path d="M50.9198 40.6797H47.4501C47.4541 40.6095 47.4561 40.539 47.4561 40.4683C47.4561 40.3971 47.4541 40.326 47.45 40.2552H50.9198V40.6797ZM36.6009 40.2552H39.9739C39.9698 40.3261 39.9678 40.3972 39.9678 40.4683C39.9678 40.5389 39.9698 40.6094 39.9738 40.6797H36.6009V40.2552Z" stroke="white" stroke-width="4.78583"/>
                                    </svg>
                                    <h5>All Device Compatible</h5>
                                </div>
                            </div>
                            <!-- item end  -->

                        </div>
                    </div>



                </div>
            </div>
            <!-- mange shop left part  end -->
            <!-- mange shop right part  end -->
            <div class="col-lg-4">
                <div class="manage_shop_img">
                    <img class="img-fluid" src="{{ asset('landing/images/mange_banner.png')}}" alt="">
                </div>
            </div>
        </div>
        <!-- mange shop left part  end -->




    </div>

</section>


<!-- Sections Gaps -->
<div class="section_gaps"></div>


<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------
    business   PART
---------------------------------------------------------------------------------------------------------------------------------------------------  -->
<section id="business-sector">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 m-auto">
                <div class="business_sector_header">
                    <h2>Business Sectors <span>Those Can Use Our Service</span> </h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eget proin aliquet eget massa quis mi netus mi. Morbi sed id amet faucibus dolor, auctor. Pulvinar vitae risus leo.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- slider in business -->
    <div id="business_slider">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="slider_item">
                        <div class="owl-carousel owl-theme">
                            <!-- item 1  -->
                            <div class="item">
                                <img class="img-fluid"  src="{{ asset('landing/images/slider_icon/Watch.png')}}" alt="">
                                <h4>Watch & Clock Shop</h4>
                            </div>
                            <!-- item 2  -->

                            <div class="item">
                                <img class="img-fluid"  src="{{ asset('landing/images/slider_icon/Grocery.png')}}" alt="">
                                <h4>Grocery/Organic Foods Farm</h4>
                            </div>

                            <!-- item 3  -->
                            <div class="item">
                                <img class="img-fluid"  src="{{ asset('landing/images/slider_icon/Furniture.png')}}" alt="">
                                <h4>Furniture & Household Business</h4>
                            </div>
                            <!-- item 4  -->

                            <div class="item">
                                <img class="img-fluid"  src="{{ asset('landing/images/slider_icon/Fashion.png')}}" alt="">
                                <h4>Fashion & Clothing Store</h4>
                            </div>
                            <!-- item 5  -->
                            <div class="item">
                                <img class="img-fluid"  src="{{ asset('landing/images/slider_icon/Electronics.png') }}'" alt="">
                                <h4>Electronics & Smart Gadget Shop</h4>
                            </div>
                            <!-- item 6  -->

                            <div class="item">
                                <img class="img-fluid"  src="{{ asset('landing/images/slider_icon/Medical.png') }}" alt="">
                                <h4>Medical & Hospital Equipment Shop</h4>
                            </div>
                            <!-- item 7  -->
                            <div class="item">
                                <img class="img-fluid"  src="{{ asset('anding/images/slider_icon/Perfume.png') }}" alt="">
                                <h4>Perfume & Body Spray Store</h4>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</section>

<!-- Sections Gaps -->
<div class="section_gaps"></div>

<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------
    shop theme  PART
---------------------------------------------------------------------------------------------------------------------------------------------------  -->
<section id="shop_theme">
    <div class="container">
        <!-- shop them header  -->
        <div class="row">
            <div class="col-lg-10 m-auto">
                <div class="shop_theme_header">
                    <h2>Choose Your <span>Shop Theme</span></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eget proin aliquet eget massa quis mi netus mi. Morbi sed id amet faucibus dolor, auctor. Pulvinar vitae risus leo.</p>
                </div>
            </div>
        </div>

        <!-- shop theme card  -->
        <div class="row">

            <!-- theme card 1  -->
            <div class="col-lg-4">
                <div class="shop_theme-card_contain">
                    <div class="shop_theme-card_contain_img">
                        <img  class="img-fluid" src="landing/images/theme/farnichar.png" alt="">
                    </div>
                    <div class="shop_theme-card_footer d-flex align-items-center justify-content-evenly">
                        <div class="text">
                            <h5>Demo Theme 1</h5>
                            <h6>Furniture & Interior Business</h6>

                        </div>
                        <div class="bg">
                            <a href=""> <button>View Demo</button></a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- theme card 2  -->
            <div class="col-lg-4">
                <div class="shop_theme-card_contain">
                    <div class="shop_theme-card_contain_img">
                        <img  class="img-fluid" src="landing/images/theme/Group 2149.png" alt="">
                    </div>
                    <div class="shop_theme-card_footer d-flex align-items-center justify-content-evenly">
                        <div class="text">
                            <h5>Demo Theme 2</h5>
                            <h6>Grocery/Organic Foods Farm</h6>

                        </div>
                        <div class="bg">
                            <a href=""> <button>View Demo</button></a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- theme card 2  -->

            <div class="col-lg-4">
                <div class="shop_theme-card_contain">
                    <div class="shop_theme-card_contain_img">
                        <img  class="img-fluid" src="landing/images/theme/Group 2150.png" alt="">
                    </div>
                    <div class="shop_theme-card_footer d-flex align-items-center justify-content-evenly">
                        <div class="text">
                            <h5>Demo Theme 3</h5>
                            <h6>Grocery/Organic Foods Farm</h6>

                        </div>
                        <div class="bg">
                            <a href=""> <button>View Demo</button></a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- theme card 4  -->
            <div class="col-lg-4">
                <div class="shop_theme-card_contain">
                    <div class="shop_theme-card_contain_img">
                        <img  class="img-fluid" src="landing/images/theme/Group 2150.png" alt="">
                    </div>
                    <div class="shop_theme-card_footer d-flex align-items-center justify-content-evenly">
                        <div class="text">
                            <h5>Demo Theme 3</h5>
                            <h6>Grocery/Organic Foods Farm</h6>

                        </div>
                        <div class="bg">
                            <a href=""> <button>View Demo</button></a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- theme card 5  -->
            <div class="col-lg-4">
                <div class="shop_theme-card_contain">
                    <div class="shop_theme-card_contain_img">
                        <img  class="img-fluid" src="landing/images/theme/Group 2150.png" alt="">
                    </div>
                    <div class="shop_theme-card_footer d-flex align-items-center justify-content-evenly">
                        <div class="text">
                            <h5>Demo Theme 3</h5>
                            <h6>Grocery/Organic Foods Farm</h6>

                        </div>
                        <div class="bg">
                            <a href=""> <button>View Demo</button></a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- theme card 6  -->
            <div class="col-lg-4">
                <div class="shop_theme-card_contain">
                    <div class="shop_theme-card_contain_img">
                        <img  class="img-fluid" src="landing/images/theme/Mask group (1).png" alt="">
                    </div>
                    <div class="shop_theme-card_footer d-flex align-items-center justify-content-evenly">
                        <div class="text">
                            <h5>Demo Theme 3</h5>
                            <h6>Grocery/Organic Foods Farm</h6>

                        </div>
                        <div class="bg">
                            <a href=""> <button>View Demo</button></a>
                        </div>
                    </div>

                </div>
            </div>


        </div>
        <div class="view_all_theme">
            <a href=""> <button>View All Themes</button></a>
        </div>
    </div>

</section>


<!-- Sections Gaps -->
<div class="section_gaps"></div>

<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------
  Single Product Website Theme  PART
---------------------------------------------------------------------------------------------------------------------------------------------------  -->
<section id="shop_theme">
    <div class="container">
        <!-- shop them header  -->
        <div class="row">
            <div class="col-lg-10 m-auto">
                <div class="shop_theme_header">
                    <h2>Choose Your <span>Single Product Website Theme</span></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eget proin aliquet eget massa quis mi netus mi. Morbi sed id amet faucibus dolor, auctor. Pulvinar vitae risus leo.</p>
                </div>
            </div>
        </div>

        <!-- shop theme card  -->
        <div class="row">

            <!-- theme card 1  -->
            <div class="col-lg-4">
                <div class="shop_theme-card_contain">
                    <div class="shop_theme-card_contain_img">
                        <img  class="img-fluid" src="landing/images/single page theme/Mask group (1).png" alt="">
                    </div>
                    <div class="shop_theme-card_footer d-flex align-items-center justify-content-evenly">
                        <div class="text">
                            <h5>Demo Theme 1</h5>
                            <h6>Furniture & Interior Business</h6>

                        </div>
                        <div class="bg">
                            <a href=""> <button>View Demo</button></a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- theme card 2  -->
            <div class="col-lg-4">
                <div class="shop_theme-card_contain">
                    <div class="shop_theme-card_contain_img">
                        <img  class="img-fluid" src="landing/images/single page theme/Mask group (2).png" alt="">
                    </div>
                    <div class="shop_theme-card_footer d-flex align-items-center justify-content-evenly">
                        <div class="text">
                            <h5>Demo Theme 2</h5>
                            <h6>Grocery/Organic Foods Farm</h6>

                        </div>
                        <div class="bg">
                            <a href=""> <button>View Demo</button></a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- theme card 2  -->

            <div class="col-lg-4">
                <div class="shop_theme-card_contain">
                    <div class="shop_theme-card_contain_img">
                        <img  class="img-fluid" src="landing/images/single page theme/Mask group (3).png" alt="">
                    </div>
                    <div class="shop_theme-card_footer d-flex align-items-center justify-content-evenly">
                        <div class="text">
                            <h5>Demo Theme 3</h5>
                            <h6>Grocery/Organic Foods Farm</h6>

                        </div>
                        <div class="bg">
                            <a href=""> <button>View Demo</button></a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- theme card 4  -->
            <div class="col-lg-4">
                <div class="shop_theme-card_contain">
                    <div class="shop_theme-card_contain_img">
                        <img  class="img-fluid" src="landing/images/single page theme/Mask group (4).png" alt="">
                    </div>
                    <div class="shop_theme-card_footer d-flex align-items-center justify-content-evenly">
                        <div class="text">
                            <h5>Demo Theme 3</h5>
                            <h6>Grocery/Organic Foods Farm</h6>

                        </div>
                        <div class="bg">
                            <a href=""> <button>View Demo</button></a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- theme card 5  -->
            <div class="col-lg-4">
                <div class="shop_theme-card_contain">
                    <div class="shop_theme-card_contain_img">
                        <img  class="img-fluid" src="landing/images/single page theme/Mask group (5).png" alt="">
                    </div>
                    <div class="shop_theme-card_footer d-flex align-items-center justify-content-evenly">
                        <div class="text">
                            <h5>Demo Theme 3</h5>
                            <h6>Grocery/Organic Foods Farm</h6>

                        </div>
                        <div class="bg">
                            <a href=""> <button>View Demo</button></a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- theme card 6  -->
            <div class="col-lg-4">
                <div class="shop_theme-card_contain">
                    <div class="shop_theme-card_contain_img">
                        <img  class="img-fluid" src="landing/images/single page theme/Mask group (6).png" alt="">
                    </div>
                    <div class="shop_theme-card_footer d-flex align-items-center justify-content-evenly">
                        <div class="text">
                            <h5>Demo Theme 3</h5>
                            <h6>Grocery/Organic Foods Farm</h6>

                        </div>
                        <div class="bg">
                            <a href=""> <button>View Demo</button></a>
                        </div>
                    </div>

                </div>
            </div>


        </div>
        <div class="view_all_theme">
            <a href=""> <button>View All Themes</button></a>
        </div>
    </div>

</section>


<!-- Sections Gaps -->
<div class="section_gaps"></div>

<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------
    slider  PART
---------------------------------------------------------------------------------------------------------------------------------------------------  -->
<section id="slider">
    <div class="container">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="https://swiperjs.com/demos/images/nature-1.jpg" />
                </div>
                <div class="swiper-slide">
                    <img src="https://swiperjs.com/demos/images/nature-2.jpg" />
                </div>
                <div class="swiper-slide">
                    <img src="https://swiperjs.com/demos/images/nature-3.jpg" />
                </div>
                <div class="swiper-slide">
                    <img src="https://swiperjs.com/demos/images/nature-4.jpg" />
                </div>
                <div class="swiper-slide">
                    <img src="https://swiperjs.com/demos/images/nature-5.jpg" />
                </div>
                <div class="swiper-slide">
                    <img src="https://swiperjs.com/demos/images/nature-6.jpg" />
                </div>
                <div class="swiper-slide">
                    <img src="https://swiperjs.com/demos/images/nature-7.jpg" />
                </div>
                <div class="swiper-slide">
                    <img src="https://swiperjs.com/demos/images/nature-8.jpg" />
                </div>
                <div class="swiper-slide">
                    <img src="https://swiperjs.com/demos/images/nature-9.jpg" />
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>

    </div>

</section>

<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------
    Subscription Package  PART
---------------------------------------------------------------------------------------------------------------------------------------------------  -->
<section id="subscriptio_package">
    <div class="container">
        <!-- subscription package header   -->
        <div class="row">
            <div class="col-lg-10 m-auto">
                <div class="shop_theme_header">
                    <h2>Choose Your <span>Subscription Package</span></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eget proin aliquet eget massa quis mi netus mi. Morbi sed id amet faucibus dolor, auctor. Pulvinar vitae risus leo.</p>
                </div>
            </div>
        </div>
        <!-- subscription package card   -->
        <div class="row">

            <!-- subscription card item 1  -->
            <div class="col-lg-4">
                <div class="subscription_card_contain">
                    <div class="subscription_card_header">
                        <h4>Silver Package</h4>
                        <h3>BDT 1000</h3>
                        <h6>Every Month</h6>
                        <hr>
                    </div>
                    <div class="subscript_list">
                        <ul>
                            <li><svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_1242_1333)">
                                        <rect x="10" y="10" width="26" height="26" rx="13" fill="white"/>
                                    </g>
                                    <path d="M16 22.9057L21.8868 27.8113L29.7358 18" stroke="#5DCA08" stroke-width="2.5"/>
                                    <defs>
                                        <filter id="filter0_d_1242_1333" x="0" y="0" width="46" height="46" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1242_1333"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1242_1333" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                                Dashboard Full Access</li>
                            <li><svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_1242_1333)">
                                        <rect x="10" y="10" width="26" height="26" rx="13" fill="white"/>
                                    </g>
                                    <path d="M16 22.9057L21.8868 27.8113L29.7358 18" stroke="#5DCA08" stroke-width="2.5"/>
                                    <defs>
                                        <filter id="filter0_d_1242_1333" x="0" y="0" width="46" height="46" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1242_1333"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1242_1333" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                                Access To All Themes</li>

                            <li><svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_1242_1333)">
                                        <rect x="10" y="10" width="26" height="26" rx="13" fill="white"/>
                                    </g>
                                    <path d="M16 22.9057L21.8868 27.8113L29.7358 18" stroke="#5DCA08" stroke-width="2.5"/>
                                    <defs>
                                        <filter id="filter0_d_1242_1333" x="0" y="0" width="46" height="46" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1242_1333"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1242_1333" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                                5000 Free Bulk SMS</li>
                            <li><svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_1242_1334)">
                                        <rect x="10" y="10" width="26" height="26" rx="13" fill="white"/>
                                    </g>
                                    <path d="M27.7547 18L18 27.7547M18 18L27.7547 27.7547" stroke="#FE0707" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <defs>
                                        <filter id="filter0_d_1242_1334" x="0" y="0" width="46" height="46" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1242_1334"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1242_1334" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                                Full Analytics Report</li>

                            <li><svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_1242_1334)">
                                        <rect x="10" y="10" width="26" height="26" rx="13" fill="white"/>
                                    </g>
                                    <path d="M27.7547 18L18 27.7547M18 18L27.7547 27.7547" stroke="#FE0707" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <defs>
                                        <filter id="filter0_d_1242_1334" x="0" y="0" width="46" height="46" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1242_1334"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1242_1334" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                                Unlimited Product Storage</li>

                            <li><svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_1242_1334)">
                                        <rect x="10" y="10" width="26" height="26" rx="13" fill="white"/>
                                    </g>
                                    <path d="M27.7547 18L18 27.7547M18 18L27.7547 27.7547" stroke="#FE0707" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <defs>
                                        <filter id="filter0_d_1242_1334" x="0" y="0" width="46" height="46" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1242_1334"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1242_1334" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>Unlimited Plugins</li>
                        </ul>
                    </div>
                    <div class="subscript_button">
                        <a href=""> <button>Get Started</button></a>
                    </div>
                </div>
            </div>
            <!-- subscription card item 1  -->
            <div class="col-lg-4">
                <div class="subscription_card_contain">
                    <div class="subscription_card_header">
                        <h4>Gold Package</h4>
                        <h3>BDT 2000</h3>
                        <h6>Every Month</h6>
                        <hr>
                    </div>
                    <div class="subscript_list">
                        <ul>
                            <li><svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_1242_1333)">
                                        <rect x="10" y="10" width="26" height="26" rx="13" fill="white"/>
                                    </g>
                                    <path d="M16 22.9057L21.8868 27.8113L29.7358 18" stroke="#5DCA08" stroke-width="2.5"/>
                                    <defs>
                                        <filter id="filter0_d_1242_1333" x="0" y="0" width="46" height="46" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1242_1333"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1242_1333" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                                Dashboard Full Access</li>
                            <li><svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_1242_1333)">
                                        <rect x="10" y="10" width="26" height="26" rx="13" fill="white"/>
                                    </g>
                                    <path d="M16 22.9057L21.8868 27.8113L29.7358 18" stroke="#5DCA08" stroke-width="2.5"/>
                                    <defs>
                                        <filter id="filter0_d_1242_1333" x="0" y="0" width="46" height="46" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1242_1333"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1242_1333" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                                Access To All Themes</li>

                            <li><svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_1242_1333)">
                                        <rect x="10" y="10" width="26" height="26" rx="13" fill="white"/>
                                    </g>
                                    <path d="M16 22.9057L21.8868 27.8113L29.7358 18" stroke="#5DCA08" stroke-width="2.5"/>
                                    <defs>
                                        <filter id="filter0_d_1242_1333" x="0" y="0" width="46" height="46" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1242_1333"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1242_1333" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                                5000 Free Bulk SMS</li>
                            <li>
                                <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_1242_1333)">
                                        <rect x="10" y="10" width="26" height="26" rx="13" fill="white"/>
                                    </g>
                                    <path d="M16 22.9057L21.8868 27.8113L29.7358 18" stroke="#5DCA08" stroke-width="2.5"/>
                                    <defs>
                                        <filter id="filter0_d_1242_1333" x="0" y="0" width="46" height="46" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1242_1333"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1242_1333" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                                Full Analytics Report</li>

                            <li><svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_1242_1334)">
                                        <rect x="10" y="10" width="26" height="26" rx="13" fill="white"/>
                                    </g>
                                    <path d="M27.7547 18L18 27.7547M18 18L27.7547 27.7547" stroke="#FE0707" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <defs>
                                        <filter id="filter0_d_1242_1334" x="0" y="0" width="46" height="46" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1242_1334"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1242_1334" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                                Unlimited Product Storage</li>

                            <li><svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_1242_1334)">
                                        <rect x="10" y="10" width="26" height="26" rx="13" fill="white"/>
                                    </g>
                                    <path d="M27.7547 18L18 27.7547M18 18L27.7547 27.7547" stroke="#FE0707" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <defs>
                                        <filter id="filter0_d_1242_1334" x="0" y="0" width="46" height="46" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1242_1334"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1242_1334" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>Unlimited Plugins</li>
                        </ul>
                    </div>
                    <div class="subscript_button">
                        <a href=""> <button>Get Started</button></a>
                    </div>
                </div>
            </div>

            <!-- subscription card item 1  -->
            <div class="col-lg-4">
                <div class="subscription_card_contain">
                    <div class="subscription_card_header">
                        <h4>Diamond Package</h4>
                        <h3>BDT 3500</h3>
                        <h6>Every Month</h6>
                        <hr>
                    </div>
                    <div class="subscript_list">
                        <ul>
                            <li><svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_1242_1333)">
                                        <rect x="10" y="10" width="26" height="26" rx="13" fill="white"/>
                                    </g>
                                    <path d="M16 22.9057L21.8868 27.8113L29.7358 18" stroke="#5DCA08" stroke-width="2.5"/>
                                    <defs>
                                        <filter id="filter0_d_1242_1333" x="0" y="0" width="46" height="46" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1242_1333"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1242_1333" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                                Dashboard Full Access</li>
                            <li><svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_1242_1333)">
                                        <rect x="10" y="10" width="26" height="26" rx="13" fill="white"/>
                                    </g>
                                    <path d="M16 22.9057L21.8868 27.8113L29.7358 18" stroke="#5DCA08" stroke-width="2.5"/>
                                    <defs>
                                        <filter id="filter0_d_1242_1333" x="0" y="0" width="46" height="46" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1242_1333"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1242_1333" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                                Access To All Themes</li>

                            <li><svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_1242_1333)">
                                        <rect x="10" y="10" width="26" height="26" rx="13" fill="white"/>
                                    </g>
                                    <path d="M16 22.9057L21.8868 27.8113L29.7358 18" stroke="#5DCA08" stroke-width="2.5"/>
                                    <defs>
                                        <filter id="filter0_d_1242_1333" x="0" y="0" width="46" height="46" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1242_1333"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1242_1333" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                                5000 Free Bulk SMS</li>
                            <li><svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_1242_1333)">
                                        <rect x="10" y="10" width="26" height="26" rx="13" fill="white"/>
                                    </g>
                                    <path d="M16 22.9057L21.8868 27.8113L29.7358 18" stroke="#5DCA08" stroke-width="2.5"/>
                                    <defs>
                                        <filter id="filter0_d_1242_1333" x="0" y="0" width="46" height="46" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1242_1333"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1242_1333" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                                Full Analytics Report</li>

                            <li><svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_1242_1333)">
                                        <rect x="10" y="10" width="26" height="26" rx="13" fill="white"/>
                                    </g>
                                    <path d="M16 22.9057L21.8868 27.8113L29.7358 18" stroke="#5DCA08" stroke-width="2.5"/>
                                    <defs>
                                        <filter id="filter0_d_1242_1333" x="0" y="0" width="46" height="46" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1242_1333"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1242_1333" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                                Unlimited Product Storage</li>

                            <li><svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_d_1242_1333)">
                                        <rect x="10" y="10" width="26" height="26" rx="13" fill="white"/>
                                    </g>
                                    <path d="M16 22.9057L21.8868 27.8113L29.7358 18" stroke="#5DCA08" stroke-width="2.5"/>
                                    <defs>
                                        <filter id="filter0_d_1242_1333" x="0" y="0" width="46" height="46" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset/>
                                            <feGaussianBlur stdDeviation="5"/>
                                            <feComposite in2="hardAlpha" operator="out"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0 0.608247 0 0 0 0.25 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1242_1333"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1242_1333" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                                Unlimited Plugins</li>
                        </ul>
                    </div>
                    <div class="subscript_button">
                        <a href=""> <button>Get Started</button></a>
                    </div>
                </div>
            </div>



        </div>

    </div>
</section>



<!-- Sections Gaps -->
<div class="section_gaps"></div>
<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------
    ask question  PART
---------------------------------------------------------------------------------------------------------------------------------------------------  -->
<section id="ask_question">
    <div class="container">
        <!--  ask question header   -->
        <div class="row">
            <div class="col-lg-10 m-auto">
                <div class="shop_theme_header">
                    <h2>Frequently <span>Asked Questions</span></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eget proin aliquet eget massa quis mi netus mi. Morbi sed id amet faucibus dolor, auctor. Pulvinar vitae risus leo.</p>
                </div>
            </div>
        </div>
        <!--  ask question card   -->


        <!-- ask question main   -->
        <div class="row">
            <div class="col-lg-6">
                <!-- ask question -->
                <div class="ask_quest-main">
                    <div class="accordion" id="accordion">
                        <!-- item  1 -->
                        <div class="accordion-item border border-0">
                            <h2 class="accordion-header" id="one">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-one" aria-expanded="true" aria-controls="collapse-one">
                                    Where can I watch?
                                </button>
                            </h2>
                            <div id="collapse-one" class="accordion-collapse collapse show" aria-labelledby="one" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Nibh quisque suscipit fermentum netus nulla cras porttitor euismod nulla. Orci, dictumst nec aliquet id ullamcorper venenatis. .</p>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <!-- item  2 -->
                        <div class="accordion-item border border-0">
                            <h2 class="accordion-header" id="two">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-two" aria-expanded="false" aria-controls="collapse-two">
                                    Mauris id nibh eu fermentum mattis purus?
                                </button>
                            </h2>
                            <div id="collapse-two" class="accordion-collapse collapse" aria-labelledby="two" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>Eros imperdiet rhoncus?</p>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <!-- item  3 -->
                        <div class="accordion-item border border-0">
                            <h2 class="accordion-header" id="three">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-three" aria-expanded="false" aria-controls="collapse-three">
                                    Fames imperdiet quam fermentum?
                                </button>
                            </h2>
                            <div id="collapse-three" class="accordion-collapse collapse" aria-labelledby="three" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>This is accordion body.</p>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <!-- item  4 -->
                        <div class="accordion-item border border-0">
                            <h2 class="accordion-header" id="four">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-four" aria-expanded="false" aria-controls="collapse-four">
                                    Fames imperdiet quam fermentum?
                                </button>
                            </h2>
                            <div id="collapse-four" class="accordion-collapse collapse" aria-labelledby="four" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>This is accordion body.</p>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <!-- item end  -->


                        <!-- item  5 -->
                        <div class="accordion-item border border-0">
                            <h2 class="accordion-header" id="five">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-five" aria-expanded="false" aria-controls="collapse-five">
                                    Fames imperdiet quam fermentum?
                                </button>
                            </h2>
                            <div id="collapse-five" class="accordion-collapse collapse" aria-labelledby="five" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>This is accordion body.</p>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <!-- item end  -->


                        <!-- item  6 -->
                        <div class="accordion-item border border-0">
                            <h2 class="accordion-header" id="six">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-six" aria-expanded="false" aria-controls="collapse-six">
                                    Fames imperdiet quam fermentum?
                                </button>
                            </h2>
                            <div id="collapse-six" class="accordion-collapse collapse" aria-labelledby="six" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>This is accordion body.</p>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <!-- item end  -->

                        <!-- item 7  -->
                        <div class="accordion-item border border-0">
                            <h2 class="accordion-header" id="seven">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-seven" aria-expanded="false" aria-controls="collapse-seven">
                                    Fames imperdiet quam fermentum?
                                </button>
                            </h2>
                            <div id="collapse-seven" class="accordion-collapse collapse" aria-labelledby="seven" data-bs-parent="#accordion">
                                <div class="accordion-body">
                                    <p>This is accordion body.</p>
                                </div>
                            </div>
                            <hr>
                        </div>
                        <!-- item end  -->
                    </div>
                </div>

            </div>
            <div class="col-lg-6">
                <!-- ask question img  -->
                <div class="ask_right_img">
                    <img  class="img-fluid" src="landing/images/ask.png" alt="">
                </div>

            </div>
        </div>
    </div>
</section>


<!-- Sections Gaps -->
<div class="section_gaps"></div>
<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------
    Social Media  PART
---------------------------------------------------------------------------------------------------------------------------------------------------  -->
<section id="social_media">
    <div class="container">
        <!--  Social Media  header   -->
        <div class="row">
            <div class="col-lg-10 m-auto">
                <div class="shop_theme_header">
                    <h2>Join Us On <span>Social Media</span></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eget proin aliquet eget massa quis mi netus mi. Morbi sed id amet faucibus dolor, auctor. Pulvinar vitae risus leo.</p>
                </div>
            </div>
        </div>
        <!--  Social Media  header  end  -->


        <!-- Social Media icon  -->
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="social_icon d-flex" >
                    <div class="facebook" >
                        <img class="img-fluid"  src="landing/images/social/Vector (2).png" alt="">
                    </div>
                    <div class="facebook">
                        <img class="img-fluid"  src="landing/images/social/Vector (3).png" alt="">
                    </div>
                    <div class="facebook">
                        <img class="img-fluid"  src="landing/images/social/Vector (4).png" alt="">
                    </div>
                    <div class="facebook">
                        <img class="img-fluid"  src="landing/images/social/Vector.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Sections Gaps -->
<div class="section_gaps"></div>

<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------
    toatal client clounter  PART
---------------------------------------------------------------------------------------------------------------------------------------------------  -->
<section id="total_count">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 m-auto">
                <div class="totall_achieve_contain">
                    <div class="row">
                        <!-- item  -->
                        <div class="col-lg-3">
                            <div class="total_achievements">
                                <h2>2000+</h2>
                                <h3>Clients Onboarded</h3>
                            </div>
                        </div>


                        <!-- item  -->
                        <div class="col-lg-3">
                            <div class="total_achievements">
                                <h2>50+</h2>
                                <h3>Shop Themes</h3>
                            </div>
                        </div>
                        <!-- item  -->
                        <div class="col-lg-3">
                            <div class="total_achievements">
                                <h2>100+</h2>
                                <h3>Shop Crearted</h3>
                            </div>
                        </div>
                        <!-- item  -->
                        <div class="col-lg-3">
                            <div class="total_achievements">
                                <h2>590+</h2>
                                <h3>Plugin Added</h3>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</section>


<!-- Sections Gaps -->
<div class="section_gaps"></div>
<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------
    footer   PART
---------------------------------------------------------------------------------------------------------------------------------------------------  -->
<section id="footer">
    <div class="container">
        <div class="row">

            <div class="col-lg-6">
                <div class="footer_left">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="address">
                                <h3>Address</h3>
                                <hr>
                                <h4>52 Bedok Reservoir Cres
                                    Singapore 479226</h4>
                            </div>
                            <div class="contract">
                                <h3>Contact No.</h3>
                                <hr>
                                <h4>+880 123 456 789</h4>
                                <h4>+880 123 456 789</h4>
                            </div>
                            <div class="d-flex align-sm-items-center flex-lg-column">
                                <div class="email_addres">
                                    <h3>E-mail Address</h3>
                                    <hr>
                                    <h4>support@salesolution.com</h4>
                                </div>
                                <div class="footer_logo">
                                    <img class="img-fluid"  src="landing/images/footer_logo.png" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="link">
                                <h3>Quick Links</h3>
                                <hr>
                                <a href="">Home</a>
                                <a href="">Feature</a>
                                <a href="">Themes</a>
                                <a href="">Pricing</a>
                                <a href="">Blogs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="footer_right">
                    <!-- <img class="img-fluid"  src="landing/images/form.png" alt=""> -->
                    <div class="form">
                        <form>
                            <div class="form-floating custom_input_form mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Full Name">
                                <label for="floatingInput">Full Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Contact Number">
                                <label for="floatingPassword">Contact Number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="E-mail Address">
                                <label for="floatingPassword">E-mail Address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="Enter Your Message" id="floatingTextarea2" style="height: 100px"></textarea>
                                <label for="floatingTextarea2">Enter Your Message</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>




<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------
    START  PART
---------------------------------------------------------------------------------------------------------------------------------------------------  -->



<!-- JS Link -->
<script src="landing/js/jquery-1.12.4.min.js"></script>
<script src="landing/js/bootstrap.bundle.min.js"></script>
<script src="landing/js/owl.carousel.min.js"></script>
<script>
    // let loder =document.getElementById('loading');
    // function myFunction() {
    //     loder.style.display ='node';
    // }
    var preloader = document.getElementById("loading");
    // window.addEventListener('load', function(){
    // 	preloader.style.display = 'none';
    // 	})

    function myFunction(){
        preloader.style.display = 'none';
    };
</script>


<script src="landing/js/slick.js"></script>
<script src="landing/js/all.min.js"></script>
<script src="landing/js/custom.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>


<script type="text/javascript" >
    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:false,
        dots:true,
        autoplay:true,
        responsive:{
            0:{
                items:2
            },
            600:{
                items:3
            },
            1000:{
                items:7
            }
        }
    })
</script>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper(".mySwiper", {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        coverflowEffect: {
            rotate: 50,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: true,
        },
        pagination: {
            el: ".swiper-pagination",
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
</script>
<script>
    AOS.init();
</script>

</body>

</html>
