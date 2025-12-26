/**
 * GSAP Scroll Effects
 * 
 * Text animation on scroll using GSAP SplitText and ScrollTrigger
 */

(function() {
	'use strict';

	// Wait for DOM and GSAP to load
	document.addEventListener('DOMContentLoaded', function() {
		// Check if GSAP and required plugins are loaded
		if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
			console.warn('GSAP or ScrollTrigger is not loaded');
			return;
		}

		// Check for SplitText
		if (typeof SplitText === 'undefined') {
			console.warn('SplitText is not loaded');
			return;
		}

	// Register GSAP plugins
	gsap.registerPlugin(SplitText, ScrollTrigger);

	/**
	 * Check if device is mobile
	 * @returns {boolean}
	 */
	function isMobile() {
		return window.innerWidth <= 768;
	}

	/**
	 * Check if Elementor editor is active
	 * @returns {boolean}
	 */
	function isElementorEditor() {
		// Check multiple ways Elementor editor can be detected
		if (typeof elementorFrontend !== 'undefined' && elementorFrontend.isEditMode && elementorFrontend.isEditMode()) {
			return true;
		}
		if (document.body.classList.contains('elementor-editor-active')) {
			return true;
		}
		if (window.location.href.indexOf('elementor-preview') !== -1) {
			return true;
		}
		if (document.querySelector('.elementor-editor-preview')) {
			return true;
		}
		return false;
	}

	/**
	 * Initialize title animation for .bt-gsap-animation-title
	 * Stagger animation - animate words one by one
	 */
	function initTitleAnimation() {
		// Disable on mobile and in Elementor editor
		if (isMobile() || isElementorEditor()) {
			return;
		}
			document.fonts.ready.then(() => {
				const containers = document.querySelectorAll('.bt-gsap-animation-title:not([data-gsap-title-initialized])');

				if (containers.length === 0) {
					return;
				}

				containers.forEach((container) => {
					container.setAttribute('data-gsap-title-initialized', 'true');

					// Find heading element
					const textElement = container.querySelector('h1, h2, h3, h4, h5, h6, .elementor-heading-title') || container;
					
					if (!textElement || !textElement.textContent.trim()) {
						return;
					}

					// Set initial opacity
					gsap.set(textElement, { opacity: 1 });

					let animation;

					// Create SplitText instance with words for stagger animation
					SplitText.create(textElement, {
						type: "words",
						wordsClass: "bt-gsap-title-word",
						autoSplit: true,
						onSplit: (instance) => {
							// Kill existing animation if any
							if (animation) {
								animation.kill();
							}

							// Stagger animation: animate words one by one with impressive effects
							animation = gsap.from(instance.words, {
								y: 100,
								opacity: 0,
								rotation: 15,
								scale: 0.5,
								duration: 1.2,
								stagger: 0.1,
								ease: 'back.out(1.7)',
								scrollTrigger: {
									trigger: container,
									start: 'top 85%', // Start animation when top reaches 85%
									end: 'bottom top', // End when bottom leaves top of viewport (completely out of screen)
                                    toggleActions: "play none none none",
								}
							});

							return animation;
						}
					});
				});

				ScrollTrigger.refresh();
			});
		}

	/**
	 * Initialize title long animation for .bt-gsap-animation-title-long
	 * Stagger animation with random word appearance
	 */
	function initTitleLongAnimation() {
		// Disable on mobile and in Elementor editor
		if (isMobile() || isElementorEditor()) {
			return;
		}
			document.fonts.ready.then(() => {
				const containers = document.querySelectorAll('.bt-gsap-animation-title-long:not([data-gsap-title-long-initialized])');

				if (containers.length === 0) {
					return;
				}

				containers.forEach((container) => {
					container.setAttribute('data-gsap-title-long-initialized', 'true');

					// Find heading element
					const textElement = container.querySelector('h1, h2, h3, h4, h5, h6, .elementor-heading-title') || container;
					
					if (!textElement || !textElement.textContent.trim()) {
						return;
					}

					// Set initial opacity
					gsap.set(textElement, { opacity: 1 });

					let animation;

					// Get original text color and convert to RGB before splitting
					const originalColor = window.getComputedStyle(textElement).color;
					const rgbMatch = originalColor.match(/\d+/g);
					const r = rgbMatch ? rgbMatch[0] : 0;
					const g = rgbMatch ? rgbMatch[1] : 0;
					const b = rgbMatch ? rgbMatch[2] : 0;

					// Set initial dim color immediately - before SplitText creates words
					gsap.set(textElement, {
						color: `rgba(${r}, ${g}, ${b}, 0.1)`
					});

					// Create SplitText instance with words (for smooth word-by-word lighting)
					SplitText.create(textElement, {
						type: "words",
						wordsClass: "bt-gsap-title-long-word",
						autoSplit: true,
						onSplit: (instance) => {
							// Kill existing animation if any
							if (animation) {
								animation.kill();
							}

							// Ensure all words start with dim color
							gsap.set(instance.words, {
								color: `rgba(${r}, ${g}, ${b}, 0.05)`
							});

							// Animate words with scrub - text lights up word by word as you scroll
							animation = gsap.to(instance.words, {
								color: `rgba(${r}, ${g}, ${b}, 1)`,
								duration: 1,
								stagger: {
									amount: 2,
									from: "start"
								},
								ease: 'none', // Linear for smooth scrub
								scrollTrigger: {
									trigger: container,
									start: 'top 92%',
									end: 'bottom 40%',
									scrub: 0.5 // Smoother scrub for better performance
								}
							});

							return animation;
						}
					});
				});

				ScrollTrigger.refresh();
			});
		}

	/**
	 * Initialize text paragraph animation for .bt-gsap-animation-text in elementor-widget-text-editor
	 * Subtle animation - animate each paragraph as a whole, preserve margins
	 */
	function initTextAnimation() {
		// Disable on mobile and in Elementor editor
		if (isMobile() || isElementorEditor()) {
			return;
		}
			document.fonts.ready.then(() => {
				// Find text editor widgets with animation class
				const textEditors = document.querySelectorAll('.elementor-widget-text-editor.bt-gsap-animation-text:not([data-gsap-text-initialized])');

				if (textEditors.length === 0) {
					return;
				}

				textEditors.forEach((container) => {
					container.setAttribute('data-gsap-text-initialized', 'true');

					// Find all paragraph elements in text editor
					const paragraphs = container.querySelectorAll('.elementor-widget-container p, .elementor-text-editor p, p');
					
					if (paragraphs.length === 0) {
						return;
					}

					// Animate each paragraph as a whole (preserve margins between paragraphs)
					paragraphs.forEach((paragraph, index) => {
						if (!paragraph.textContent.trim()) {
							return;
						}

						// Set initial state - more visible starting point
						gsap.set(paragraph, {
							opacity: 0,
							y: 60,
							scale: 0.7
						});

						// Clearer animation for each paragraph
						gsap.to(paragraph, {
							opacity: 1,
							y: 0,
							scale: 1,
							duration: 1.2,
							delay: index * 0.15, // Slightly longer delay between paragraphs
							ease: 'power3.out',
							scrollTrigger: {
								trigger: paragraph,
								start: 'top 100%', // Start earlier
								end: 'bottom 70%',
								toggleActions: "play none none none",
								// markers: true // Uncomment for debugging
							}
						});
					});
				});

				ScrollTrigger.refresh();
			});
		}

	/**
	 * Initialize box animation for .bt-gsap-animation-box
	 * Stagger animation - animate each .elementor-column one by one
	 */
	function initBoxAnimation() {
		// Disable on mobile and in Elementor editor
		if (isMobile() || isElementorEditor()) {
			return;
		}

		document.fonts.ready.then(() => {
			const containers = document.querySelectorAll('.bt-gsap-animation-box:not([data-gsap-box-initialized])');

			if (containers.length === 0) {
				return;
			}

			containers.forEach((container) => {
				container.setAttribute('data-gsap-box-initialized', 'true');

				// Find all column elements
				const columns = container.querySelectorAll('.elementor-column');
				
				if (columns.length === 0) {
					return;
				}

				// Set initial state for all columns
				gsap.set(columns, {
					opacity: 0,
					y: 80,
					scale: 0.9
				});

				// Stagger animation: animate columns one by one
				gsap.to(columns, {
					opacity: 1,
					y: 0,
					scale: 1,
					duration: 1,
					stagger: 0.2, // Delay between each column
					ease: 'power3.out',
					scrollTrigger: {
						trigger: container,
						start: 'top 40%', 
						end: 'bottom 70%',
						toggleActions: "play none none none" 
					}
				});
			});

			ScrollTrigger.refresh();
		});
	}

		// Initialize all animations
		initTitleAnimation();
		initTitleLongAnimation();
		initTextAnimation();
		initBoxAnimation();

		// Support for Elementor
		if (typeof elementorFrontend !== 'undefined') {
			jQuery(window).on('elementor/frontend/init', function() {
				setTimeout(function() {
					// Re-initialize after Elementor loads
					document.querySelectorAll('.bt-gsap-animation-title[data-gsap-title-initialized]').forEach((el) => {
						el.removeAttribute('data-gsap-title-initialized');
					});
					document.querySelectorAll('.bt-gsap-animation-title-long[data-gsap-title-long-initialized]').forEach((el) => {
						el.removeAttribute('data-gsap-title-long-initialized');
					});
					document.querySelectorAll('.bt-gsap-animation-text[data-gsap-text-initialized]').forEach((el) => {
						el.removeAttribute('data-gsap-text-initialized');
					});
					document.querySelectorAll('.bt-gsap-animation-box[data-gsap-box-initialized]').forEach((el) => {
						el.removeAttribute('data-gsap-box-initialized');
					});
					initTitleAnimation();
					initTitleLongAnimation();
					initTextAnimation();
					initBoxAnimation();
					ScrollTrigger.refresh();
				}, 300);
			});
		}

		// Refresh on resize
		let resizeTimer;
		window.addEventListener('resize', function() {
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(function() {
				// Re-initialize on resize to recalculate
				document.querySelectorAll('.bt-gsap-animation-title[data-gsap-title-initialized]').forEach((el) => {
					el.removeAttribute('data-gsap-title-initialized');
				});
				document.querySelectorAll('.bt-gsap-animation-title-long[data-gsap-title-long-initialized]').forEach((el) => {
					el.removeAttribute('data-gsap-title-long-initialized');
				});
				document.querySelectorAll('.bt-gsap-animation-text[data-gsap-text-initialized]').forEach((el) => {
					el.removeAttribute('data-gsap-text-initialized');
				});
				document.querySelectorAll('.bt-gsap-animation-box[data-gsap-box-initialized]').forEach((el) => {
					el.removeAttribute('data-gsap-box-initialized');
				});
				initTitleAnimation();
				initTitleLongAnimation();
				initTextAnimation();
				initBoxAnimation();
				ScrollTrigger.refresh();
			}, 300);
		});

	});

})();
