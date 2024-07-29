@extends('home.header')

@section('content')
<style>
	@media only screen and (max-width: 1140px){
		.main-slider .slide.slide-one {
			background-image: url(/template/Finano/Finano-Placeholder/images/mobile2.png)!important;
		}
	}
	
</style>
		<!--Main Slider-->
		<section class="main-slider" style="background-image:url(/template/Finano/Finano-Placeholder/images/background/1.png)">
			<div class="main-slider-carousel owl-carousel owl-theme" style="background:black;">

				<div class="slide slide-one" style="background-image:url(/template/Finano/Finano-Placeholder/images/banner3.png);">
					<div class="auto-container">
						<div class="content">
							<h1>{{ __('site.Unlocking a New Era') }}<br> {{ __('site.of') }} <span>{{ __('site.Prosperity') }}</span></h1>
							<div class="text">{{ __('site.A Revolutionary Financial Insurance Module That Guarantees Results') }} </div>
							<div class="link-box">
								<a href="https://winato.co/register?ref_id=1SA25Z34" class="theme-btn btn-style-one">{{ __('site.SIGN UP') }} <span
										class="icon flaticon-link"></span></a>
							</div>
						</div>
					</div>
				</div>

				<!-- <div class="slide slide-one" style="background-image:url(/template/Finano/Finano-Placeholder/images/main-slider/1.png)">
					<div class="auto-container">
						<div class="content">
							<h1>Unlocking a New Era <br> of <span>Prosperity</span></h1>
							<div class="text">A Revolutionary Financial Insurance Module That Guarantees Results </div>
							<div class="link-box">
								<a href="./web" class="theme-btn btn-style-one">SIGN UP <span
										class="icon flaticon-link"></span></a>
							</div>
						</div>
					</div>
				</div> -->

			</div>
			<!--End Slide Info Boxed-->

		</section>
		<!--End Main Slider-->


		<!-- News Section Two -->
		<section class="news-section-two alternate">
			<div class="auto-container">
				<!-- Sec Title -->
				<div class="sec-title-two centered">
					<h2>{{ __('site.Why') }}  <span>{{ __('site.US') }}</span> ?</h2>
				</div>

				<div class="row clearfix">

					<!-- News Block Two -->
					<div class="news-block-two brown col-lg-3 col-md-6 col-sm-12">
						<div class="inner-box wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
							<div class="lower-content">
								<h5><a href="blog-single.html">{{ __('site.Complimentary insurance coverage for modern financial') }}</a></h5>
							</div>
						</div>
					</div>

					<!-- News Block Two -->
					<div class="news-block-two brown col-lg-3 col-md-6 col-sm-12">
						<div class="inner-box wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1500ms">
							<div class="lower-content">
								<h5><a href="blog-single.html">{{ __('site.Seamlessly merging Insurance and Trading') }}</a></h5>
								<div class="text d-none text-desc">
								{{ __('site.Home_1') }}
								</div>

								<button class="theme-btn btn-style-ten">{{ __('site.Read more') }}</button>

							</div>
						</div>
					</div>

					<!-- News Block Two -->
					<div class="news-block-two brown col-lg-3 col-md-6 col-sm-12">
						<div class="inner-box wow fadeInUp" data-wow-delay="600ms" data-wow-duration="1500ms">
							<div class="lower-content">
								<h5><a href="blog-single.html">{{ __('site.Ensuring daily profits for our clients with zero riskinvolved') }}</a></h5>
								<div class="text d-none text-desc">
								{{ __('site.Home_2') }}
								</div><button class="theme-btn btn-style-ten">{{ __('site.Read more') }}</button>
							</div>
						</div>
					</div>

					<!-- News Block Two -->
					<div class="news-block-two brown col-lg-3 col-md-6 col-sm-12">
						<div class="inner-box wow fadeInUp" data-wow-delay="900ms" data-wow-duration="1500ms">
							<div class="lower-content">
								<h5><a href="blog-single.html">{{ __('site.Win-win situations') }}</a></h5>
								<div class="text d-none text-desc">
								{{ __('site.Home_3') }}
								</div><button class="theme-btn btn-style-ten">{{ __('site.Read more') }}</button>
							</div>
						</div>
					</div>

				</div>

			</div>
		</section>

		<section class="about-section-two">
			<div class="auto-container">
				<div class="row clearfix">
					
					
					<!-- Content Column -->
					<div class="content-column col-lg-8 col-md-12 col-sm-12">
						<div class="inner-column">
							<h5>{{ __('site.How It Works?') }}</h5>
							<div class="text">
								<h3>{{ __('site.Get started in 3 simple steps') }}</h3>
							</div>
							<div class="blocks-outer">
													
								<!-- Services Block Seven -->
								<div class="services-block-seven">
									<div class="inner-box">
										<div class="icon-box">
											1
										</div>
										<div class="text">{{ __('site.Sign up with Winato and get verified within minutes') }}</div>
									</div>
								</div>
								
								<!-- Services Block Seven -->
								<div class="services-block-seven">
									<div class="inner-box">
										<div class="icon-box">
											2
										</div>
										<div class="text">{{ __('site.Add funds to our trusted trading partners') }}</div>
									</div>
								</div>
								
								<!-- Services Block Seven -->
								<div class="services-block-seven">
									<div class="inner-box">
										<div class="icon-box">
											3
										</div>
										<div class="text">{{ __('site.Follow Winato trading instructions and start trading with insurance coverage') }}</div>
									</div>
								</div>
								
							</div>
							<a href="/register" class="theme-btn btn-style-three">{{ __('site.GET STARTED') }}</a>
						</div>
					</div>

					<!-- Video Column -->
					<div class="video-column col-lg-4 col-md-12 col-sm-12">
						<div class="inner-column">
							<!--Video Box-->
							<div class="video-box">
								<figure class="image">
									<img src="/template/Finano/Finano-Placeholder/images/web3.png" alt="">
								</figure>
							</div>
						</div>
					</div>
					
					
				</div>
			</div>
		</section>

		<!-- About Section -->
		<section class="about-section">
			<div class="auto-container">
				<div class="row clearfix align-items-center">

					<!-- Content Column -->
					<div class="content-column col-lg-6 col-md-12 col-sm-12">
						<div class="inner-column">

							<!-- Sec Title -->
							<div class="sec-title">
								<div class="title">{{ __('site.About us') }}</div>
								<h2>{{ __('site.With our business model,') }}<br><span>{{ __('site.we have……') }}</span></h2>
							</div>
							<div class="row clearfix">
								<div class="column col-12">
									<ul class="list-style-one">
										<li>{{ __('site.Helped more than 4000 traders to achieve consistent profits from day trading') }}
										</li>
									</ul>
								</div>
								<div class="column col-12">
									<ul class="list-style-one">
										<li>{{ __('site.Payout up to $400,000 insurance coverage to our clients') }}</li>
									</ul>
								</div>
								<div class="column col-12">
									<ul class="list-style-one">
										<li>{{ __('site.Developed more than 1000 full time traders worldwide') }}</li>
									</ul>
								</div>
							</div>
						</div>
					</div>

					<!-- Video Column -->
					<div class="video-column col-lg-6 col-md-12 col-sm-12">
						<div class="inner-column">
							<div class="fact-counter">
								<div class="auto-container">
									<div class="row clearfix">

										<!--Column-->
										<div class="column counter-column col-lg-4 col-md-6 col-sm-12">
											<div class="inner wow fadeInLeft" data-wow-delay="0ms"
												data-wow-duration="1500ms">
												<div class="count-outer count-box">
													<span class="count-text" data-speed="2000"
														data-stop="4000">0</span>+
													<div class="counter-title">{{ __('site.Satisfied Traders') }}</div>
												</div>
											</div>
										</div>

										<!--Column-->
										<div class="column counter-column col-lg-4 col-md-6 col-sm-12">
											<div class="inner wow fadeInLeft" data-wow-delay="300ms"
												data-wow-duration="1500ms">
												<div class="count-outer count-box">
													$<span class="count-text" data-speed="3500"
														data-stop="400000">0</span>
													<div class="counter-title">{{ __('site.Satisfied Traders') }}</div>
												</div>
											</div>
										</div>

										<!--Column-->
										<div class="column counter-column col-lg-4 col-md-12 col-sm-12">
											<div class="inner wow fadeInLeft" data-wow-delay="600ms"
												data-wow-duration="1500ms">
												<div class="count-outer count-box">
													<span class="count-text" data-speed="2000"
														data-stop="1000">0</span>+
													<div class="counter-title">{{ __('site.Full Time Trader') }}</div>
												</div>
											</div>
										</div>

									</div>
								</div>
							</div>

						</div>
					</div>

				</div>
			</div>
		</section>
		<!-- End About Section -->

		<!-- Testimonial Section -->
		<section class="testimonial-section"  style="background-image:url(/template/Finano/Finano-Placeholder/images/web4.png)">
			<div class="auto-container">
				<div class="single-item-carousel owl-carousel owl-theme">

					<!-- Testimonial Block -->
					<div class="testimonial-block">
						<div class="inner-box">
							<div class="quote-icon">
								<span class="icon flaticon-right-quote-sign"></span>
							</div>
							<div class="text">{{ __('site.Testimonial_1') }} </div>

						</div>
					</div>

					<!-- Testimonial Block -->
					<div class="testimonial-block">
						<div class="inner-box">
							<div class="quote-icon">
								<span class="icon flaticon-right-quote-sign"></span>
							</div>
							<div class="text">{{ __('site.Testimonial_2') }} </div>
						</div>
					</div>

					<!-- Testimonial Block -->
					<div class="testimonial-block">
						<div class="inner-box">
							<div class="quote-icon">
								<span class="icon flaticon-right-quote-sign"></span>
							</div>
							<div class="text">{{ __('site.Testimonial_3') }} </div>
						</div>
					</div>

					<!-- Testimonial Block -->
					<div class="testimonial-block">
						<div class="inner-box">
							<div class="quote-icon">
								<span class="icon flaticon-right-quote-sign"></span>
							</div>
							<div class="text">{{ __('site.Testimonial_4') }}</div>
						</div>
					</div>

				</div>
			</div>
		</section>
		<!-- End Testimonial Section -->
@stop