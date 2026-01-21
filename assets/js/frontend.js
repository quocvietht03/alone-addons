(function ($) {
	/**
	   * @param $scope The Widget wrapper element as a jQuery element
	 * @param $ The jQuery alias
	 */
	var CounterHandler = function ($scope, $) {
		//console.log($scope);
		var $selector = $scope.find('.elementor-counter__number'),
			$dataCounter = $selector.data('counter'),
			waypoint = new Waypoint({
				element: $selector,
				handler: function () {
					$selector.numerator($dataCounter);
				},
				offset: '100%',
				triggerOnce: true
			});

	};

	var CountDownHandler = function ($scope, $) {
		//console.log($scope);
		$scope.find('.countdown').each(function () {
			var $countdownTime = $(this).attr('data-countdown'),
				$countdownFormat = $(this).attr('data-format');

			$(this).countdown({
				until: $countdownTime,
				format: $countdownFormat,
				padZeroes: true
			});

		});
	};

	var MagnificPopupHandler = function ($scope, $) {
		// console.log($scope);
		$scope.find('.elementor-open-popup-link').magnificPopup({
			type: 'inline',
			midClick: true
		});

	};

	var FilterPostHandler = function ($scope, $) {
		//console.log($scope);
		// Get all items
		var items = [];
		$scope.find('.elementor-item').each(function () {
			items.push('<div class="animate__hide ' + $(this).attr('class') + '" data-group="' + $(this).data('group') + '">' + $(this).html() + '</div>');
		});

		// click filter navigation
		$scope.find('.elementor-filter a').click(function (e) {
			e.preventDefault();
			if ($(this).hasClass('active')) {
				return;
			}

			$('.elementor-filter a').removeClass('active');
			$(this).addClass('active');

			var group = $(this).data('filter');
			$scope.find('.elementor-item').addClass('animate__hide');
			$scope.find('.elementor-item').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
				$scope.find('.elementor-grid').html(''); // empty list content

				// get filter result
				var result = '';
				if ('all' === group) {
					result = items;
				} else {
					for (var i = 0; i < items.length; i++) {
						if ($(items[i]).data('group').split(' ').includes(group)) {
							result += items[i];
						}
					};
				}

				if ('' === result) {
					result += '<div class="elementor-' + $scope.find('.elementor-filter').data('type') + ' elementor-item no-result" data-group="' + group + '"><strong>No result.</strong> Please add post to category!</div>';

				}

				$scope.find('.elementor-grid').html(result);
				$scope.find('.elementor-item').removeClass('animate__hide').addClass('animate__show');

				$scope.find('.give-card__progress-custom .give-goal-progress').each(function () {
					if (!$(this).parent().hasClass('give-card__progress-custom') || !$(this).find('.give-progress-bar').length) {
						return;
					}

					getProgressBarFilter($(this));

				});

			});
		});

	};

	var TestimonialSpecialHandler = function ($scope, $) {
		// console.log($scope);
		$scope.find('.elementor-test-special__tab-item').on('click', function () {
			if (!$(this).hasClass('active')) {
				var tabIndex = $(this).data('index');

				$scope.find('.elementor-test-special__tab-item').removeClass('active');
				$(this).addClass('active');

				$scope.find('.elementor-test-special__panel-item').removeClass('active');
				$scope.find('.elementor-test-special__panel-item[data-index="' + tabIndex + '"]').addClass('active');

			}
		});

		$scope.find('.elementor-test-special__nav-btn').on('click', function (e) {
			e.preventDefault();

			var tabIndex = $scope.find('.elementor-test-special__tab-item.active').data('index');

			if ($(this).hasClass('elementor-test-special__nav-prev')) {
				if (tabIndex == 0) {
					$scope.find('.elementor-test-special__tab-item[data-index="2"]').click();
				}
				if (tabIndex == 1) {
					$scope.find('.elementor-test-special__tab-item[data-index="0"]').click();
				}
				if (tabIndex == 2) {
					$scope.find('.elementor-test-special__tab-item[data-index="1"]').click();
				}
			} else {
				if (tabIndex == 0) {
					$scope.find('.elementor-test-special__tab-item[data-index="1"]').click();
				}
				if (tabIndex == 1) {
					$scope.find('.elementor-test-special__tab-item[data-index="2"]').click();
				}
				if (tabIndex == 2) {
					$scope.find('.elementor-test-special__tab-item[data-index="0"]').click();
				}
			}

			console.log(tabIndex);

		});

	};

	function getPieChart($selector) {
		//console.log($selector);
		var $innerText = $selector.data('innertext'),
			$strokeWidth = $selector.data('strokewidth'),
			$easing = $selector.data('easing'),
			$duration = $selector.data('duration'),
			$color = $selector.data('color'),
			$trailColor = $selector.data('trailcolor'),
			$trailWidth = $selector.data('trailwidth'),
			$toColor = $selector.data('tocolor');
		$svgWidth = $selector.data('width'),
			$svgHeight = $selector.data('height');

		var bar = new ProgressBar.Circle($selector[0], {
			strokeWidth: $strokeWidth,
			easing: $easing,
			duration: $duration,
			color: $color,
			trailColor: $trailColor,
			trailWidth: $trailWidth,
			svgStyle: { width: $svgWidth, height: $svgHeight },
			from: { color: $color },
			to: { color: $toColor },
			step: (state, bar) => {
				bar.path.setAttribute('stroke', state.color);

				var value = Math.round(bar.value() * 100);
				if ($innerText) {
					bar.setText(value + '% <span>' + $innerText + '</span>');
				} else {
					bar.setText(value + '%');
				}

			}
		});

		var $barWidth = $selector.attr('aria-valuenow') / 100,

			waypoint = new Waypoint({
				element: $selector,
				handler: function () {
					bar.animate($barWidth);  // Number from 0.0 to 1.0
				},
				offset: '100%',
				triggerOnce: true
			});
	}

	var PieChartHandler = function ($scope, $) {
		//console.log($scope);
		$scope.find('.elementor-pie-chart__progress').each(function () {
			if (!$(this).length) {
				return;
			}
			getPieChart($(this));

		});

	};

	function getProgressBar($selector) {

		$selector.find('.give-progress-bar').css('display', 'none');

		var $type = $selector.parent().data('type'),
			$strokeWidth = $selector.parent().data('strokewidth'),
			$easing = $selector.parent().data('easing'),
			$duration = $selector.parent().data('duration'),
			$color = $selector.parent().data('color'),
			$trailColor = $selector.parent().data('trailcolor'),
			$trailWidth = $selector.parent().data('trailwidth'),
			$toColor = $selector.parent().data('tocolor');
		$svgWidth = $selector.parent().data('width'),
			$svgHeight = $selector.parent().data('height');

		if ('circle' === $type) {
			var bar = new ProgressBar.Circle($selector[0], {
				strokeWidth: $strokeWidth,
				easing: $easing,
				duration: $duration,
				color: $color,
				trailColor: $trailColor,
				trailWidth: $trailWidth,
				svgStyle: { width: $svgWidth, height: $svgHeight },
				from: { color: $color },
				to: { color: $toColor },
				step: (state, bar) => {
					bar.path.setAttribute('stroke', state.color);
					var value = Math.round(bar.value() * 100) + '%';
					if (value === 0) {
						bar.setText('');
					} else {
						bar.setText(value);
					}
				}
			});
		} else {
			var bar = new ProgressBar.Line($selector[0], {
				strokeWidth: $strokeWidth,
				easing: $easing,
				duration: $duration,
				color: $color,
				trailColor: $trailColor,
				trailWidth: $trailWidth,
				svgStyle: { width: $svgWidth, height: $svgHeight },
				from: { color: $color },
				to: { color: $toColor },
				step: (state, bar) => {
					bar.path.setAttribute('stroke', state.color);
				}
			});
		}

		var $barWidth = $selector.find('.give-progress-bar').attr('aria-valuenow') / 100,

			waypoint = new Waypoint({
				element: $selector,
				handler: function () {
					bar.animate($barWidth);  // Number from 0.0 to 1.0
				},
				offset: '100%',
				triggerOnce: true
			});
	}

	function getProgressBarFilter($selector) {

		$selector.find('.give-progress-bar').css('display', 'none');

		var $type = $selector.parent().data('type'),
			$strokeWidth = $selector.parent().data('strokewidth'),
			$easing = $selector.parent().data('easing'),
			$duration = $selector.parent().data('duration'),
			$color = $selector.parent().data('color'),
			$trailColor = $selector.parent().data('trailcolor'),
			$trailWidth = $selector.parent().data('trailwidth'),
			$toColor = $selector.parent().data('tocolor');
		$svgWidth = $selector.parent().data('width'),
			$svgHeight = $selector.parent().data('height');

		if ('circle' === $type) {
			var bar = new ProgressBar.Circle($selector[0], {
				strokeWidth: $strokeWidth,
				easing: $easing,
				duration: $duration,
				color: $color,
				trailColor: $trailColor,
				trailWidth: $trailWidth,
				svgStyle: { width: $svgWidth, height: $svgHeight },
				from: { color: $color },
				to: { color: $toColor },
				step: (state, bar) => {
					bar.path.setAttribute('stroke', state.color);
					var value = Math.round(bar.value() * 100) + '%';
					if (value === 0) {
						bar.setText('');
					} else {
						bar.setText(value);
					}
				}
			});
		} else {
			var bar = new ProgressBar.Line($selector[0], {
				strokeWidth: $strokeWidth,
				easing: $easing,
				duration: $duration,
				color: $color,
				trailColor: $trailColor,
				trailWidth: $trailWidth,
				svgStyle: { width: $svgWidth, height: $svgHeight },
				from: { color: $color },
				to: { color: $toColor },
				step: (state, bar) => {
					bar.path.setAttribute('stroke', state.color);
				}
			});
		}

		var $barWidth = $selector.find('.give-progress-bar').attr('aria-valuenow') / 100;

		bar.animate($barWidth);  // Number from 0.0 to 1.0
	}

	var ProgressbarHandler = function ($scope, $) {
		//console.log($scope);
		$scope.find('.give-card__progress-custom .give-goal-progress').each(function () {
			if (!$(this).parent().hasClass('give-card__progress-custom') || !$(this).find('.give-progress-bar').length) {
				return;
			}

			getProgressBar($(this));

		});

	};

	var SwiperSliderHandler = function ($scope, $) {
		//console.log($scope);
		var $selector = $scope.find('.swiper-container'),
			$dataSwiper = $selector.data('swiper'),
			mySwiper = new Swiper($selector, $dataSwiper);
	};

	var SwiperSliderThumbsHandler = function ($scope, $) {
		//console.log($scope);
		var $selector_thumbs = $scope.find('.swiper-thumbs .swiper-container'),
			$dataSwiperThumbs = $selector_thumbs.data('swiper'),
			thumbSwiper = new Swiper($selector_thumbs, $dataSwiperThumbs);

		var $selector = $scope.find('.swiper-main .swiper-container'),
			$dataSwiper = $selector.data('swiper');

		$dataSwiper['thumbs'] = { swiper: thumbSwiper, };
		var mainSwiper = new Swiper($selector, $dataSwiper);
	};

	var SaladoSliderHandler = function ($scope, $) {
		var $widget = $scope.find('.be-salado-slider-wrapper');

		if (!$widget.length || $widget.attr('data-initialized') === 'true') {
			return;
		}

		// Check if GSAP is loaded
		if (typeof gsap === 'undefined') {
			console.warn('GSAP is not loaded for Salado Slider widget');
			// Fallback to regular Swiper handler with fade effect
			var $selector = $scope.find('.swiper-container'),
				$dataSwiper = $selector.data('swiper');

			// Parse swiper data if it's a string, otherwise use as is
			var swiperConfig = typeof $dataSwiper === 'string' ? JSON.parse($dataSwiper) : $dataSwiper;

			// Add fade effect to Swiper config
			swiperConfig.effect = 'fade';
			swiperConfig.fadeEffect = {
				crossFade: true
			};

			var mySwiper = new Swiper($selector, swiperConfig);
			return;
		}

		$widget.attr('data-initialized', 'true');

		var $selector = $scope.find('.swiper-container'),
			$dataSwiper = $selector.data('swiper');

		// Parse swiper data if it's a string, otherwise use as is
		var swiperConfig = typeof $dataSwiper === 'string' ? JSON.parse($dataSwiper) : $dataSwiper;

		// Add fade effect to Swiper config
		swiperConfig.effect = 'fade';
		swiperConfig.fadeEffect = {
			crossFade: true
		};

		// Initialize Swiper with fade effect
		var mySwiper = new Swiper($selector, swiperConfig);
		var previousIndex = 0;

		/**
		 * Animate slide content with GSAP
		 * @param {jQuery} $slide - jQuery slide element
		 * @param {boolean} isInitial - Is this the initial load animation
		 */
		function animateSlideContent($slide, isInitial) {
			if (!$slide.length) {
				return;
			}

			var $subHeading = $slide.find('.be-salado-slider--sub-heading');
			var $heading = $slide.find('.be-salado-slider--heading');
			var $description = $slide.find('.be-salado-slider--description');
			var $buttonWrapper = $slide.find('.be-salado-slider--button-wrapper');
			var $button = $slide.find('.be-salado-slider--button');
			var $peopleDonation = $slide.find('.be-salado-slider--people-donation');
			var $imageInner = $slide.find('.be-salado-slider--image-inner img');
			var $imageContainer = $slide.find('.be-salado-slider--image-inner');

			// Create timeline for slide animation
			var tl = gsap.timeline();

			// Collect elements that exist for initial state
			// Note: people-donation is inside button-wrapper, so we don't add it separately
			var elementsToAnimate = [];
			if ($subHeading.length) elementsToAnimate.push($subHeading[0]);
			if ($description.length) elementsToAnimate.push($description[0]);
			if ($buttonWrapper.length) elementsToAnimate.push($buttonWrapper[0]);

			// Set initial states only for elements that exist
			// CSS already sets initial hidden state, GSAP will override and animate
			if (isInitial) {
				// Initial load - CSS already hides elements, GSAP will animate from CSS state
				if (elementsToAnimate.length > 0) {
					gsap.set(elementsToAnimate, {
						opacity: 0,
						y: 50
					});
				}
				if ($imageContainer.length && $imageInner.length) {
					// Set perspective for 3D effect
					gsap.set($imageContainer[0], {
						perspective: 1000
					});
					gsap.set($imageInner[0], {
						opacity: 0,
						scale: 1.2,
						filter: 'blur(8px) brightness(0.7)',
						transformOrigin: 'center center'
					});
				}
			} else {
				// Slide transition - set elements based on direction
				var slideDirection = mySwiper.activeIndex > previousIndex ? 1 : -1;

				if (elementsToAnimate.length > 0) {
					gsap.set(elementsToAnimate, {
						opacity: 0,
						y: 50 * slideDirection
					});
				}
				if ($imageContainer.length && $imageInner.length) {
					// Set perspective for 3D effect
					gsap.set($imageContainer[0], {
						perspective: 1000
					});
					gsap.set($imageInner[0], {
						opacity: 0,
						scale: 1.2,
						x: 30 * slideDirection,
						filter: 'blur(8px) brightness(0.7)',
						rotationY: 10 * slideDirection,
						transformOrigin: 'center center'
					});
				}
			}

			// Animate image with beautiful effect - zoom + fade + blur + subtle 3D rotation
			if ($imageInner.length) {
				tl.to($imageInner[0], {
					opacity: 1,
					scale: 1,
					x: 0,
					rotationY: 0,
					filter: 'blur(0px) brightness(1)',
					duration: 1.4,
					ease: 'power3.out'
				}, 0);
			}

			// Animate sub heading
			if ($subHeading.length) {
				tl.to($subHeading[0], {
					opacity: 1,
					y: 0,
					duration: 0.8,
					ease: 'power3.out'
				}, 0.2);
			}

			// Animate heading with stagger effect for words
			if ($heading.length) {
				var headingElement = $heading[0];
				var headingText = $heading.text().trim();

				// First, ensure heading container is visible (override CSS opacity: 0)
				gsap.set(headingElement, {
					opacity: 1,
					clearProps: 'transform' // Clear CSS transform so GSAP can control it
				});

				if (headingText && headingText.length > 0) {
					// Check if already wrapped
					var $words = $heading.find('.gsap-word');

					if ($words.length === 0) {
						// Wrap words in spans for stagger animation
						var words = headingText.split(/\s+/).filter(function (word) {
							return word && word.length > 0;
						});

						if (words.length > 0) {
							var wrappedText = '';
							words.forEach(function (word, index) {
								wrappedText += '<span class="gsap-word" style="display: inline-block;">' + word + '</span>';
								if (index < words.length - 1) {
									wrappedText += ' ';
								}
							});
							$heading.html(wrappedText);
							$words = $heading.find('.gsap-word');
						}
					}

					if ($words.length > 0) {
						// Animate words with stagger
						gsap.set($words.toArray(), {
							opacity: 0,
							y: 30,
							rotationX: -90
						});

						tl.to($words.toArray(), {
							opacity: 1,
							y: 0,
							rotationX: 0,
							duration: 0.6,
							stagger: 0.08,
							ease: 'back.out(1.2)'
						}, 0.4);
					} else {
						// Fallback: animate heading as whole if word wrapping failed
						gsap.set(headingElement, { opacity: 0, y: 50 });
						tl.to(headingElement, {
							opacity: 1,
							y: 0,
							duration: 0.8,
							ease: 'power3.out'
						}, 0.4);
					}
				} else {
					// If heading has no text, just ensure it's visible
					gsap.set(headingElement, { opacity: 1, y: 0 });
				}
			}

			// Animate description
			if ($description.length) {
				tl.to($description[0], {
					opacity: 1,
					y: 0,
					duration: 0.8,
					ease: 'power3.out'
				}, 0.6);
			}

			// Animate button wrapper (button + people donation)
			if ($buttonWrapper.length) {
				// First, ensure people-donation is visible (it's inside button-wrapper)
				if ($peopleDonation.length) {
					// Set people-donation initial state separately
					var $peopleImages = $peopleDonation.find('.be-salado-slider--people-images img');
					var $peopleText = $peopleDonation.find('.be-salado-slider--people-donation-text');

					// Set initial states for people donation elements - simple fade in for images
					if ($peopleImages.length) {
						gsap.set($peopleImages.toArray(), {
							opacity: 0
						});
					}
					if ($peopleText.length) {
						gsap.set($peopleText[0], { opacity: 0, x: -20 });
					}
					// Ensure the container itself is visible
					gsap.set($peopleDonation[0], { opacity: 1 });
				}

				// Animate button wrapper
				tl.to($buttonWrapper[0], {
					opacity: 1,
					y: 0,
					duration: 0.8,
					ease: 'power3.out'
				}, 0.8);

				// Animate button with gentle fade in
				if ($button.length) {
					gsap.set($button[0], { opacity: 0, y: 10 });
					tl.to($button[0], {
						opacity: 1,
						y: 0,
						duration: 0.8,
						ease: 'power2.out'
					}, 0.9);
				}

				// Animate people donation elements
				if ($peopleDonation.length) {
					var $peopleImages = $peopleDonation.find('.be-salado-slider--people-images img');
					var $peopleText = $peopleDonation.find('.be-salado-slider--people-donation-text');

					// Ensure people-donation container is visible first (after button-wrapper is visible)
					tl.set($peopleDonation[0], {
						opacity: 1
					}, 0.8);

					if ($peopleImages.length) {
						// Simple fade in for people images - no complex animations
						tl.to($peopleImages.toArray(), {
							opacity: 1,
							duration: 0.5,
							ease: 'power2.out'
						}, 1);
					} else {
						// If no images, ensure container is still visible
						tl.set($peopleDonation[0], {
							opacity: 1
						}, 1);
					}

					if ($peopleText.length) {
						tl.to($peopleText[0], {
							opacity: 1,
							x: 0,
							duration: 0.5,
							ease: 'power2.out'
						}, 1.1);
					} else {
						// If no text but container exists, ensure it's visible
						if (!$peopleImages.length) {
							tl.set($peopleDonation[0], {
								opacity: 1
							}, 1);
						}
					}

					// Final safety: ensure people-donation is always visible at the end
					tl.set($peopleDonation[0], {
						opacity: 1
					}, 1.5);
				}
			} else {
				// If button-wrapper doesn't exist but people-donation does, animate it separately
				if ($peopleDonation.length) {
					var $peopleImages = $peopleDonation.find('.be-salado-slider--people-images img');
					var $peopleText = $peopleDonation.find('.be-salado-slider--people-donation-text');

					gsap.set($peopleDonation[0], { opacity: 0, y: 50 });

					if ($peopleImages.length) {
						// Simple fade in for people images
						gsap.set($peopleImages.toArray(), {
							opacity: 0
						});
					}
					if ($peopleText.length) {
						gsap.set($peopleText[0], { opacity: 0, x: -20 });
					}

					tl.to($peopleDonation[0], {
						opacity: 1,
						y: 0,
						duration: 0.8,
						ease: 'power3.out'
					}, 0.8);

					if ($peopleImages.length) {
						// Simple fade in for people images - no complex animations
						tl.to($peopleImages.toArray(), {
							opacity: 1,
							duration: 0.5,
							ease: 'power2.out'
						}, 1);
					}

					if ($peopleText.length) {
						tl.to($peopleText[0], {
							opacity: 1,
							x: 0,
							duration: 0.5,
							ease: 'power2.out'
						}, 1.1);
					}
				}
			}

			return tl;
		}

		// Animate first slide on initial load
		function initFirstSlide() {
			var $firstSlide = $widget.find('.swiper-slide-active');
			if ($firstSlide.length) {
				// Check if elements exist
				var hasContent = $firstSlide.find('.be-salado-slider--content').length > 0;
				if (hasContent) {
					// Use requestAnimationFrame to ensure DOM is ready
					requestAnimationFrame(function () {
						try {
							animateSlideContent($firstSlide, true);
						} catch (e) {
							console.error('Error animating slide:', e);
							// Fallback: show all elements if animation fails
							$firstSlide.find('.be-salado-slider--sub-heading, .be-salado-slider--heading, .be-salado-slider--description, .be-salado-slider--button-wrapper, .be-salado-slider--people-donation').each(function () {
								gsap.set(this, { opacity: 1, y: 0, x: 0, scale: 1 });
							});
							// Handle image separately with filter reset
							$firstSlide.find('.be-salado-slider--image-inner img').each(function () {
								gsap.set(this, {
									opacity: 1,
									y: 0,
									x: 0,
									scale: 1,
									rotationY: 0,
									filter: 'blur(0px) brightness(1)'
								});
							});
						}
					});

					// Safety fallback: ensure elements are visible after 3 seconds
					setTimeout(function () {
						$firstSlide.find('.be-salado-slider--sub-heading, .be-salado-slider--heading, .be-salado-slider--description, .be-salado-slider--button-wrapper, .be-salado-slider--people-donation').each(function () {
							if (this && gsap.getProperty(this, 'opacity') < 0.5) {
								gsap.set(this, { opacity: 1, y: 0 });
							}
						});

						// Specifically ensure people-donation and its children are visible
						var $peopleDonation = $firstSlide.find('.be-salado-slider--people-donation');
						if ($peopleDonation.length) {
							gsap.set($peopleDonation[0], { opacity: 1, y: 0 });
							$peopleDonation.find('.be-salado-slider--people-images img').each(function () {
								if (this && gsap.getProperty(this, 'opacity') < 0.5) {
									gsap.set(this, { opacity: 1 });
								}
							});
							var $peopleText = $peopleDonation.find('.be-salado-slider--people-donation-text');
							if ($peopleText.length && $peopleText[0] && gsap.getProperty($peopleText[0], 'opacity') < 0.5) {
								gsap.set($peopleText[0], { opacity: 1, x: 0 });
							}
						}

						var $img = $firstSlide.find('.be-salado-slider--image-inner img');
						if ($img.length && $img[0] && gsap.getProperty($img[0], 'opacity') < 0.5) {
							gsap.set($img[0], {
								opacity: 1,
								scale: 1,
								x: 0,
								rotationY: 0,
								filter: 'blur(0px) brightness(1)'
							});
						}
					}, 3000);
				}
			}
		}

		// Start animation immediately after setting initial state
		// Use minimal delay just to ensure Swiper is ready
		setTimeout(function () {
			initFirstSlide();
		}, 50); // Reduced delay to prevent FOUC

		// Track slide changes and animate
		mySwiper.on('slideChange', function () {
			previousIndex = mySwiper.previousIndex;
		});

		mySwiper.on('slideChangeTransitionStart', function () {
			var $activeSlide = $widget.find('.swiper-slide-active');
			if ($activeSlide.length) {
				try {
					animateSlideContent($activeSlide, false);
				} catch (e) {
					console.error('Error animating slide transition:', e);
					// Fallback: show all elements if animation fails
					$activeSlide.find('.be-salado-slider--sub-heading, .be-salado-slider--heading, .be-salado-slider--description, .be-salado-slider--button-wrapper, .be-salado-slider--people-donation').each(function () {
						gsap.set(this, { opacity: 1, y: 0, x: 0, scale: 1 });
					});
					// Handle image separately with filter reset
					$activeSlide.find('.be-salado-slider--image-inner img').each(function () {
						gsap.set(this, {
							opacity: 1,
							y: 0,
							x: 0,
							scale: 1,
							rotationY: 0,
							filter: 'blur(0px) brightness(1)'
						});
					});
				}

				// Safety fallback: ensure elements are visible after 2 seconds
				setTimeout(function () {
					$activeSlide.find('.be-salado-slider--sub-heading, .be-salado-slider--heading, .be-salado-slider--description, .be-salado-slider--button-wrapper, .be-salado-slider--people-donation').each(function () {
						if (this && gsap.getProperty(this, 'opacity') < 0.5) {
							gsap.set(this, { opacity: 1, y: 0 });
						}
					});

					// Specifically ensure people-donation and its children are visible
					var $peopleDonation = $activeSlide.find('.be-salado-slider--people-donation');
					if ($peopleDonation.length) {
						gsap.set($peopleDonation[0], { opacity: 1, y: 0 });
						$peopleDonation.find('.be-salado-slider--people-images img').each(function () {
							if (this && gsap.getProperty(this, 'opacity') < 0.5) {
								gsap.set(this, { opacity: 1 });
							}
						});
						var $peopleText = $peopleDonation.find('.be-salado-slider--people-donation-text');
						if ($peopleText.length && $peopleText[0] && gsap.getProperty($peopleText[0], 'opacity') < 0.5) {
							gsap.set($peopleText[0], { opacity: 1, x: 0 });
						}
					}

					var $img = $activeSlide.find('.be-salado-slider--image-inner img');
					if ($img.length && $img[0] && gsap.getProperty($img[0], 'opacity') < 0.5) {
						gsap.set($img[0], {
							opacity: 1,
							scale: 1,
							x: 0,
							rotationY: 0,
							filter: 'blur(0px) brightness(1)'
						});
					}
				}, 2000);
			}
		});

		// Store swiper instance for cleanup if needed
		$widget.data('swiper-instance', mySwiper);
	};

	var GivePopupHandler = function ($scope, $) {
		//console.log($scope);
		var form_id = $scope.find('form').attr('id');

		$scope.find('button.give-btn-modal').attr('data-mfp-src', '#' + form_id);

		$scope.find('button.give-btn-modal').magnificPopup({
			type: 'inline',
			midClick: true,
			callbacks: {
				beforeOpen: function () {
					// Will fire when this exact popup is opened
					$('body').addClass('mfp-active');

					if ($scope.find('.give-form-wrap').hasClass('give-display-button')) {
						$scope.find('button.give-btn-modal').hide();
					} else {
						$scope.find('div.give-total-wrap').hide();
						$scope.find('#give-donation-level-button-wrap').hide();
						$scope.find('button.give-btn-modal').hide();
					}
				},
				beforeClose: function () {
					// Will fire when popup is closed;
					$('body').removeClass('mfp-active');

					if ($scope.find('.give-form-wrap').hasClass('give-display-button')) {
						$scope.find('button.give-btn-modal').show();
					} else {
						$('.mfp-wrap').find('div.give-total-wrap').show();
						$('.mfp-wrap').find('#give-donation-level-button-wrap').show();
						$('.mfp-wrap').find('button.give-btn-modal').show();
					}
				},
				close: function () {
					// Will fire when popup is closed
					$scope.find('form.give-form').removeClass('mfp-hide');
				}
			}
		});
	};

	var BeTogetherHandler = function ($scope, $) {
		//console.log($scope);
		var $widget = $scope.find('.be-together-wrapper');

		if (!$widget.length || $widget.attr('data-initialized') === 'true') {
			return;
		}

		// Check if GSAP is loaded
		if (typeof gsap === 'undefined') {
			console.warn('GSAP is not loaded for Be Together widget');
			return;
		}

		$widget.attr('data-initialized', 'true');

		// Animate SVG arrow on load
		var $arrow = $widget.find('.be-together-arrow');
		var $arrowPaths = $widget.find('.be-together-arrow-path');

		if ($arrow.length && $arrowPaths.length) {
			// Set initial state - hide all paths
			gsap.set($arrowPaths, {
				opacity: 0,
				scale: 0.8,
				transformOrigin: 'center center'
			});

			// Animate paths one by one
			gsap.to($arrowPaths, {
				opacity: 1,
				scale: 1,
				duration: 0.6,
				stagger: 0.1,
				ease: 'back.out(1.7)',
				delay: 0.3
			});
		}

		var headingListJson = $widget.attr('data-heading-list');
		var animationInterval = parseFloat($widget.attr('data-animation-interval')) || 3000;

		if (!headingListJson) {
			return;
		}

		var headingList;
		try {
			headingList = JSON.parse(headingListJson);
		} catch (e) {
			console.error('Error parsing heading list:', e);
			return;
		}

		// Need at least 2 items to animate
		if (headingList.length < 2) {
			return;
		}

		// Get elements
		var $highlightElement = $widget.find('.be-together-heading-highlight');
		var $descriptionElement = $widget.find('.be-together-description');
		var $arrowPaths = $widget.find('.be-together-arrow-path');

		if (!$highlightElement.length || !$descriptionElement.length) {
			return;
		}

		var currentIndex = 0;
		var animationTimeline = null;

		/**
		 * Wrap text into spans for wave animation
		 */
		function wrapTextInSpans($element) {
			var text = $element.text();
			var wrapped = '';
			for (var i = 0; i < text.length; i++) {
				var char = text[i];
				if (char === ' ') {
					wrapped += '<span class="be-together-char" style="display: inline-block;">&nbsp;</span>';
				} else {
					wrapped += '<span class="be-together-char" style="display: inline-block;">' + char + '</span>';
				}
			}
			$element.html(wrapped);
		}

		/**
		 * Initialize wave effect for heading highlight
		 */
		function initWaveEffect() {
			wrapTextInSpans($highlightElement);
		}

		// Initialize wave effect on load
		initWaveEffect();

		/**
		 * Change to next item
		 */
		function changeToNext() {
			// Calculate next index
			currentIndex = (currentIndex + 1) % headingList.length;
			var nextItem = headingList[currentIndex];

			// Create animation timeline
			if (animationTimeline) {
				animationTimeline.kill();
			}

			animationTimeline = gsap.timeline();

			// Hide SVG arrow at the start (reverse direction)
			if ($arrowPaths.length) {
				animationTimeline.to($arrowPaths, {
					opacity: 0,
					scale: 0.8,
					duration: 0.3,
					ease: 'power2.in',
					stagger: -0.1 // Reverse stagger (from last to first)
				});
			}

			// Get current characters
			var $currentChars = $highlightElement.find('.be-together-char');

			// Fade out heading highlight characters with wave effect
			if ($currentChars.length) {
				animationTimeline.to($currentChars, {
					opacity: 0,
					y: -30,
					scale: 0.8,
					duration: 0.3,
					ease: 'power2.in',
					stagger: 0.03,
					onComplete: function () {
						// Update heading highlight text
						$highlightElement.text(nextItem.heading_highlight || '');
						wrapTextInSpans($highlightElement);

						// Get new characters
						var $newChars = $highlightElement.find('.be-together-char');

						// Set initial state for new characters
						gsap.set($newChars, {
							opacity: 0,
							y: 30,
							scale: 0.8
						});

						// Animate new characters in with wave effect
						var waveAnimation = gsap.to($newChars, {
							opacity: 1,
							y: 0,
							scale: 1,
							duration: 0.5,
							ease: 'back.out(1.2)',
							stagger: 0.05,
							onComplete: function () {
								// Show SVG arrow again after wave animation completes
								if ($arrowPaths.length) {
									gsap.to($arrowPaths, {
										opacity: 1,
										scale: 1,
										duration: 0.4,
										ease: 'back.out(1.7)',
										stagger: 0.1
									});
								}
							}
						});
					}
				});
			} else {
				// Fallback if no characters found
				animationTimeline.to($highlightElement, {
					opacity: 0,
					y: -20,
					duration: 0.3,
					ease: 'power2.in',
					onComplete: function () {
						$highlightElement.text(nextItem.heading_highlight || '');
						wrapTextInSpans($highlightElement);
						var $newChars = $highlightElement.find('.be-together-char');
						gsap.set($newChars, { opacity: 0, y: 30, scale: 0.8 });
						gsap.to($newChars, {
							opacity: 1,
							y: 0,
							scale: 1,
							duration: 0.5,
							ease: 'back.out(1.2)',
							stagger: 0.05,
							onComplete: function () {
								// Show SVG arrow again after wave animation completes
								if ($arrowPaths.length) {
									gsap.to($arrowPaths, {
										opacity: 1,
										scale: 1,
										duration: 0.4,
										ease: 'back.out(1.7)',
										stagger: 0.1
									});
								}
							}
						});
					}
				});
			}

			// Fade out description with light effect
			animationTimeline.to($descriptionElement, {
				opacity: 0,
				y: -10,
				duration: 0.3,
				ease: 'power2.in'
			}, '-=0.2');

			// Update description text
			animationTimeline.call(function () {
				$descriptionElement.text(nextItem.description || '');
			});

			// Fade in description with light effect
			animationTimeline.fromTo($descriptionElement, {
				opacity: 0,
				y: 10
			}, {
				opacity: 1,
				y: 0,
				duration: 0.4,
				ease: 'power2.out'
			});
		}

		// Start first transition after half interval, then continue with full interval
		var firstTimeoutId = setTimeout(function () {
			changeToNext();

			// Start interval for subsequent transitions
			var intervalId = setInterval(changeToNext, animationInterval);

			// Store interval ID for cleanup
			$widget.attr('data-interval-id', intervalId);
		}, animationInterval / 2);

		// Store first timeout ID for cleanup
		$widget.attr('data-first-timeout-id', firstTimeoutId);
	};
	// List Circle Rotation Handler with GSAP
	var ListCircleHandler = function ($scope, $) {
		// Check if GSAP is available
		if (typeof gsap === 'undefined') {
			console.warn('GSAP is not loaded. List Circle widget requires GSAP.');
			return;
		}

		var $wrapper = $scope.find('.be-list-circle-wrapper');
		if ($wrapper.length === 0) {
			return;
		}

		var $itemsWrapper = $wrapper.find('.be-list-circle-items-wrapper');
		var $items = $itemsWrapper.find('.be-list-circle-item');
		var itemsCount = $items.length;

		if (itemsCount === 0) {
			return;
		}

		var enableRotationValue = $wrapper.attr('data-enable-rotation');
		var enableRotation = enableRotationValue === 'yes';
		var rotationSpeed = parseFloat($wrapper.data('rotation-speed')) || 60;

		// Set items initial state (scale 0, already in position)
		gsap.set($items, {
			scale: 0,
			opacity: 0
		});

		// Animate items zoom in
		var itemsTimeline = gsap.timeline();
		$items.each(function (index) {
			itemsTimeline.to(this, {
				scale: 1,
				opacity: 1,
				duration: 0.6,
				ease: 'back.out(1.7)'
			}, index * 0.1);
		});

		// Start rotation animation after items appear (only if enabled)
		if (enableRotation) {
			itemsTimeline.call(function () {
				// Rotate wrapper clockwise
				gsap.to($itemsWrapper[0], {
					rotation: 360,
					duration: rotationSpeed,
					ease: 'none',
					repeat: -1
				});

				// Rotate items counter-clockwise to keep text straight
				gsap.to($items, {
					rotation: -360,
					duration: rotationSpeed,
					ease: 'none',
					repeat: -1
				});
			});
		}
	};
	// Waves Animation Handler
	var WavesHandler = function ($scope, $) {
		var processWaves = function () {
			if ($scope.hasClass('bt-wave-animation--yes')) {
				// Check if waves SVG already exists
				if ($scope.find('.waves').length === 0) {
					var sectionId = $scope.attr('data-id') || $scope.attr('id') || Math.random().toString(36).substr(2, 9);
					var wavesSVG = '<svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">' +
						'<defs>' +
						'<path id="gentle-wave-' + sectionId + '" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>' +
						'</defs>' +
						'<g class="parallax">' +
						'<use xlink:href="#gentle-wave-' + sectionId + '" x="48" y="7" fill="#000"></use>' +
						'</g>' +
						'</svg>';
					$scope.prepend(wavesSVG);
				}
			} else {
				// Remove waves SVG if class is not present
				$scope.find('.waves').remove();
			}
		};

		// Run initially
		processWaves();

		// Watch for class changes (for Elementor editor live updates)
		if (window.elementorFrontend && window.elementorFrontend.isEditMode()) {
			var observer = new MutationObserver(function (mutations) {
				mutations.forEach(function (mutation) {
					if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
						processWaves();
					}
				});
			});

			observer.observe($scope[0], {
				attributes: true,
				attributeFilter: ['class']
			});

			// Store observer for cleanup if needed
			$scope.data('waves-observer', observer);
		}
	};
	// Make sure you run this code under Elementor.
	$(window).on('elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction('frontend/element_ready/be-counter.default', CounterHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-countdown.default', CountDownHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-pie-chart.default', PieChartHandler);

		elementorFrontend.hooks.addAction('frontend/element_ready/be-video-play-button.default', MagnificPopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-video-box.default', MagnificPopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-video-box.skin-pumori', MagnificPopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-video-box.skin-baruntse', MagnificPopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-video-box.skin-coropuna', MagnificPopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-video-box.skin-cholatse', MagnificPopupHandler);

		elementorFrontend.hooks.addAction('frontend/element_ready/be-base-carousel.default', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-base-carousel.skin-grid-pumori', SwiperSliderHandler);

		elementorFrontend.hooks.addAction('frontend/element_ready/be-salado-slider.default', SaladoSliderHandler);

		elementorFrontend.hooks.addAction('frontend/element_ready/be-logo-carousel.default', SwiperSliderHandler);

		elementorFrontend.hooks.addAction('frontend/element_ready/be-testimonial-carousel.default', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-testimonial-carousel.skin-grid-nevado', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-testimonial-carousel.skin-list-baruntse', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-testimonial-carousel.skin-list-coropuna', SwiperSliderThumbsHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-testimonial-carousel.skin-list-ampato', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-testimonial-carousel.skin-list-andrus', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-testimonial-carousel.skin-list-saltoro', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-testimonial-carousel.skin-list-changtse', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-testimonial-carousel.skin-list-changla', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-testimonial-carousel.skin-list-galloway', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-testimonial-carousel.skin-list-jorasses', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-testimonial-carousel.skin-list-cholatse', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-testimonial-carousel.skin-list-cruces', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-testimonial-carousel.skin-list-tronador', SwiperSliderHandler);

		elementorFrontend.hooks.addAction('frontend/element_ready/be-testimonial-special.default', TestimonialSpecialHandler);

		elementorFrontend.hooks.addAction('frontend/element_ready/be-members.skin-pumori', FilterPostHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-members-carousel.default', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-members-carousel.skin-pumori', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-members-carousel.skin-batura', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-members-carousel.skin-changla', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-members-carousel.skin-havsula', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-members-carousel.skin-taboche', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-members-carousel.skin-cerredo', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-members-carousel.skin-cholatse', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-members-carousel.skin-jimara', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-members-carousel.skin-nuptse', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-members-carousel.skin-cruces', SwiperSliderHandler);

		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts.skin-grid-yutmaru', FilterPostHandler);

		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.default', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-pumori', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-baruntse', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-coropuna', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-andrus', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-saltoro', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-batura', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-changtse', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-taboche', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-castor', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-wilson', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-jorasses', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-michelson', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-cerredo', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-gangri', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-sankar', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-cholatse', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-tronador', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-jimara', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-somoni', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-salado', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-swiss', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-posts-carousel.skin-grid-together', SwiperSliderHandler);

		elementorFrontend.hooks.addAction('frontend/element_ready/be-projects-carousel.default', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-projects-carousel.skin-grid-hardeol', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-projects-carousel.skin-grid-galloway', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-projects-carousel.skin-grid-jorasses', SwiperSliderHandler);

		// WooCommerce.
		elementorFrontend.hooks.addAction('frontend/element_ready/be-products-carousel.default', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-products-carousel.skin-grid-andrus', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-products-carousel.skin-grid-havsula', SwiperSliderHandler);

		// Give.
		elementorFrontend.hooks.addAction('frontend/element_ready/be-uber-menu.default', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-form-button.default', GivePopupHandler);

		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.default', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-pumori', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-pumori', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-baruntse', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-baruntse', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-coropuna', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-coropuna', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-saltoro', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-saltoro', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-taboche', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-taboche', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-galloway', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-galloway', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-wilson', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-changla', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-changla', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-jorasses', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-jorasses', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-swiss', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-swiss', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-toluca', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-totals.skin-toluca', GivePopupHandler);

		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-form.skin-andrus', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-form.skin-tronador', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-form.skin-yutmaru', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-form.skin-vaccine', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-form.skin-jimara', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-form.skin-nuptse', GivePopupHandler);

		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.default', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-pumori', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-coropuna', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-coropuna', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-list-andrus', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-changtse', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-changtse', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-hardeol', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-hardeol', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-nevado', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-taboche', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-galloway', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-havsula', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-cobble-paradis', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-cobble-castor', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-cholatse', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-tronador', FilterPostHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-tronador', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-vaccine', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-vaccine', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-yutmaru', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-yutmaru', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-platons', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-platons', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-nuptse', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-nuptse', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-gamin', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-gamin', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-toluca', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms.skin-grid-toluca', GivePopupHandler);

		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.default', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.default', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-pumori', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-pumori', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-coropuna', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-coropuna', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-coropuna', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-together', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-together', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-together', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-salado', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-salado', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-salado', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-changtse', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-changtse', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-changtse', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-hardeol', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-hardeol', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-hardeol', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-nevado', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-nevado', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-taboche', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-taboche', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-galloway', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-galloway', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-havsula', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-havsula', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-wilson', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-list-saltoro', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-list-saltoro', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-list-saltoro', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-cholatse', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-cholatse', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-vaccine', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-vaccine', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-vaccine', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-vaccine', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-yutmaru', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-yutmaru', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-yutmaru', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-platons', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-platons', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-platons', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-nuptse', ProgressbarHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-nuptse', GivePopupHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-nuptse', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-cruces', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-give-forms-carousel.skin-grid-swiss', SwiperSliderHandler);

		elementorFrontend.hooks.addAction('frontend/element_ready/be-donors-carousel.default', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-donors-carousel.skin-saltoro', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-donors-carousel.skin-taboche', SwiperSliderHandler);

		// Tribe Events.
		elementorFrontend.hooks.addAction('frontend/element_ready/be-events.skin-list-baruntse', FilterPostHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-events-carousel.default', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-events-carousel.skin-grid-andrus', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-events-carousel.skin-grid-changla', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-events-carousel.skin-grid-havsula', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-events-carousel.skin-grid-castor', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-events-carousel.skin-grid-grouse', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-events-carousel.skin-grid-sankar', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-events-carousel.skin-grid-manaslu', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-events-carousel.skin-grid-yutmaru', SwiperSliderHandler);

		// Sermone
		elementorFrontend.hooks.addAction('frontend/element_ready/be-sermone-carousel.default', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-sermone-carousel.skin-grid-grouse', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-sermone-carousel.skin-grid-michelson', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-sermone-carousel.skin-grid-gangri', SwiperSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/be-sermone-carousel.skin-grid-sankar', SwiperSliderHandler);

		// Be Together
		elementorFrontend.hooks.addAction('frontend/element_ready/be-together.default', BeTogetherHandler);

		elementorFrontend.hooks.addAction('frontend/element_ready/be-list-circle.default', ListCircleHandler);

		// Initialize waves for sections
		elementorFrontend.hooks.addAction('frontend/element_ready/section', WavesHandler);

	});

})(jQuery);
