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
	 * Initialize title animation for .bt-gsap-animation-title
	 * Stagger animation - animate words one by one
	 */
	function initTitleAnimation() {
		// Disable on mobile
		if (isMobile()) {
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
									toggleActions: "play reverse play reverse" // Play when enter, reverse when completely out, play again when re-enter
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
		// Disable on mobile
		if (isMobile()) {
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

					// Set initial dim color immediately - before SplitText creates chars
					gsap.set(textElement, {
						color: `rgba(${r}, ${g}, ${b}, 0.1)`
					});

					// Create SplitText instance with chars (for smooth character-by-character lighting)
					SplitText.create(textElement, {
						type: "chars",
						charsClass: "bt-gsap-title-long-char",
						autoSplit: true,
						onSplit: (instance) => {
							// Kill existing animation if any
							if (animation) {
								animation.kill();
							}

							// Ensure all chars start with dim color
							gsap.set(instance.chars, {
								color: `rgba(${r}, ${g}, ${b}, 0.05)`
							});

							// Animate chars with scrub - text lights up character by character as you scroll
							animation = gsap.to(instance.chars, {
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
		// Disable on mobile
		if (isMobile()) {
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

		// Initialize all animations
		initTitleAnimation();
		initTitleLongAnimation();
		initTextAnimation();

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
					initTitleAnimation();
					initTitleLongAnimation();
					initTextAnimation();
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
				initTitleAnimation();
				initTitleLongAnimation();
				initTextAnimation();
				ScrollTrigger.refresh();
			}, 300);
		});

	});

})();
