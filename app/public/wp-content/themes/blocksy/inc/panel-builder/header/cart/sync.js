import ctEvents from 'ct-events'
import { updateAndSaveEl } from '../../../../static/js/frontend/header/render-loop'
import { responsiveClassesFor } from '../../../../static/js/customizer/sync/helpers'
import { handleBackgroundOptionFor } from '../../../../static/js/customizer/sync/variables/background'
import {
	getRootSelectorFor,
	assembleSelector,
	mutateSelector,
} from '../../../../static/js/customizer/sync/helpers'

const svgs = {
	'type-1':
		'<svg viewBox="0 0 10 10"><path d="M10,8.9L9.6,1c0-0.6-0.4-1-1.1-1H1.4c-0.6,0-1,0.4-1,1L0,8.9l0,0C0,9.6,0.4,10,1,10h7.9C9.6,10,10,9.6,10,8.9L10,8.9zM8.9,9.1H1C0.9,9.1,0.9,9.1,0.9,9L1.2,1l0,0c0-0.1,0-0.1,0.1-0.1h7.2c0.1,0,0.1,0.1,0.1,0.1l0,0l0.4,7.9C9.1,9.1,9.1,9.1,8.9,9.1zM6.5,1.8C6.2,1.8,6.1,2,6.1,2.2v1.3c0,0.6-0.4,1.1-1.1,1.1c-0.6,0-1-0.5-1-1.1V2.2c0-0.2-0.2-0.5-0.5-0.5S3,1.9,3,2.2v1.3c0,1.1,0.9,1.9,1.9,1.9s1.9-0.8,1.9-1.9V2.2C6.9,2,6.8,1.8,6.5,1.8z"/></svg>',

	'type-2':
		'<svg viewBox="0 0 10 10"><path d="M0.4,0.4C0.2,0.4,0,0.5,0,0.7s0.1,0.4,0.4,0.4l0,0h0.7c0.1,0,0.1,0.1,0.1,0.1l1.6,5.4C3,7.1,3.4,7.4,3.9,7.4H8c0.5,0,0.9-0.4,1.1-0.8L10,3.1c0.1-0.2-0.1-0.4-0.3-0.4H9.6H2.4L1.9,1.1l0,0C1.9,0.6,1.5,0.4,1.1,0.4H0.4zM4.1,8.1c-0.4,0-0.7,0.4-0.7,0.7s0.4,0.7,0.7,0.7s0.7-0.4,0.7-0.7S4.5,8.1,4.1,8.1zM7.8,8.1c-0.4,0-0.7,0.4-0.7,0.7s0.4,0.7,0.7,0.7c0.4,0,0.7-0.4,0.7-0.7S8.2,8.1,7.8,8.1z"/></svg>',

	'type-3':
		'<svg viewBox="0 0 10 10"><path d="M3,0.7c-0.4,0-0.7,0.2-0.9,0.6L1.1,3.9H0.4c-0.1,0-0.3,0.1-0.4,0.2C0,4.1,0,4.3,0,4.4l1.1,4.2c0.1,0.4,0.5,0.6,0.9,0.6h5.9c0.4,0,0.8-0.3,0.9-0.6L10,4.4c0-0.1,0-0.3-0.1-0.4C9.9,3.9,9.7,3.9,9.6,3.9H8.9L7.8,1.2l0,0C7.6,0.9,7.4,0.7,7,0.7H3zM3,1.6h3.9l1,2.3H2.1L3,1.6z M3.2,5.2c0.3,0,0.4,0.2,0.4,0.4v1.8c0,0.3-0.2,0.4-0.4,0.4C3,7.9,2.8,7.6,2.8,7.4V5.7C2.7,5.4,2.9,5.2,3.2,5.2zM5,5.2c0.3,0,0.4,0.2,0.4,0.4v1.8c0,0.3-0.2,0.4-0.4,0.4c-0.3,0-0.4-0.2-0.4-0.4V5.7C4.6,5.4,4.7,5.2,5,5.2z M6.8,5.2c0.3,0,0.4,0.2,0.4,0.4v1.8c0,0.3-0.2,0.4-0.4,0.4c-0.3,0-0.4-0.2-0.4-0.4V5.7C6.4,5.4,6.6,5.2,6.8,5.2z"/></svg>',

	'type-4':
		'<svg viewBox="0 0 10 10"><path d="M3.9 0c-.5 0-1 .5-1 1.1v1.1H.3V9c0 .6.5 1.1 1.1 1.1h7.4c.6 01.1-.51.1-1.1V2.1H7.1v-1c0-.6-.5-1.1-1-1.1H3.9zm-.1.9h2.3v1.2H3.8V.9zM1.2 3.1h7.6v6H1.2v-6zm2.2 1.1c-.3 0-.5.2-.5.5s.2.5.5.5.5-.2.5-.5-.2-.5-.5-.5zm3.2 0c-.3 0-.5.2-.5.5s.2.5.5.5.5-.2.5-.5-.2-.5-.5-.5z"/></svg>',

	'type-5':
		'<svg viewBox="0 0 10 10"><path d="M9.5 2.1V2L8.1.2C8 .1 7.9 0 7.7 0H2.3c-.2 0-.3.1-.4.2L.5 2v6.7c0 .8.6 1.4 1.4 1.4h6.4c.8 0 1.4-.6 1.4-1.4V2.3c-.2-.1-.2-.1-.2-.2zM2.5.9h5l.7.9H1.8l.7-.9zm5.7 8.2H1.8c-.3 0-.5-.2-.5-.5V2.7h7.3v5.9c0 .3-.2.5-.4.5zm-.9-5c0 1.3-1 2.3-2.3 2.3s-2.3-1-2.3-2.3c0-.3.2-.5.5-.5s.5.2.5.5c0 .8.6 1.4 1.4 1.4s1.4-.6 1.4-1.4c0-.3.2-.5.5-.5.1 0 .3.2.3.5z"/></svg>',

	'type-6':
		'<svg viewBox="0 0 10 10"><path d="M10 4.2c0-.1-.1-.2-.2-.3-.1-.3-.4-.4-.6-.4h-.9L5.8.9C5.6.6 5.3.5 5 .5c-.3 0-.6.1-.8.4L1.7 3.5H.8c-.2 0-.5.1-.6.3-.1.1-.2.3-.2.5V4.9l.6 3.4c.1.8.8 1.3 1.5 1.3H7.8c.7 0 1.4-.6 1.5-1.3l.6-3.4v-.3-.2c.1-.1.1-.2.1-.2zM4.7 1.4c.1-.1.2-.2.3-.2s.2 0 .3.1l2 2.1H2.7l2-2zM2.9 7.8c-.2 0-.4-.1-.4-.4l-.1-1.7c0-.2.2-.4.4-.4s.3.2.4.4l.1 1.8c0 .1-.2.2-.4.3zm2.5-.4c0 .2-.2.4-.4.4s-.4-.2-.4-.4V5.6c0-.2.2-.4.4-.4s.4.2.4.4v1.8zm2.2-1.7l-.2 1.7c0 .2-.2.4-.4.4s-.3-.2-.3-.4l.1-1.8c0-.2.2-.4.4-.4s.4.2.4.5c0-.1 0-.1 0 0z"/></svg>',
}

ctEvents.on(
	'ct:header:sync:collect-variable-descriptors',
	(variableDescriptors) => {
		variableDescriptors['cart'] = ({ itemId }) => ({
			cartIconSize: {
				selector: assembleSelector(
					mutateSelector({
						selector: getRootSelectorFor({ itemId }),
						operation: 'suffix',
						to_add: '.ct-cart-icon',
					})
				),
				variable: 'icon-size',
				responsive: true,
				unit: 'px',
			},

			cartDropdownTopOffset: {
				selector: assembleSelector(
					mutateSelector({
						selector: getRootSelectorFor({ itemId }),
						operation: 'suffix',
						to_add: '.ct-cart-content',
					})
				),
				variable: 'dropdownTopOffset',
				unit: 'px',
			},

			cartFontColor: [
				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'suffix',
							to_add: '.ct-cart-content',
						})
					),
					variable: 'color',
					type: 'color:default',
				},

				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'suffix',
							to_add: '.ct-cart-content',
						})
					),
					variable: 'linkInitialColor',
					type: 'color:link_initial',
				},

				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'suffix',
							to_add: '.ct-cart-content',
						})
					),
					variable: 'linkHoverColor',
					type: 'color:link_hover',
				},
			],

			cartTotalFontColor: {
				selector: assembleSelector(
					mutateSelector({
						selector: getRootSelectorFor({ itemId }),
						operation: 'suffix',
						to_add: '.ct-cart-content .total',
					})
				),
				variable: 'color',
				type: 'color:default',
			},

			cartDropDownBackground: {
				selector: assembleSelector(
					mutateSelector({
						selector: getRootSelectorFor({ itemId }),
						operation: 'suffix',
						to_add: '.ct-cart-content',
					})
				),
				variable: 'backgroundColor',
				type: 'color:default',
			},

			headerCartMargin: {
				selector: assembleSelector(getRootSelectorFor({ itemId })),
				type: 'spacing',
				variable: 'margin',
				responsive: true,
				important: true,
			},

			// default state
			cartHeaderIconColor: [
				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'suffix',
							to_add: '> a',
						})
					),
					variable: 'linkInitialColor',
					type: 'color:default',
					responsive: true,
				},

				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'suffix',
							to_add: '> a',
						})
					),
					variable: 'linkHoverColor',
					type: 'color:hover',
					responsive: true,
				},
			],

			cartBadgeColor: [
				{
					selector: assembleSelector(getRootSelectorFor({ itemId })),
					variable: 'cartBadgeBackground',
					type: 'color:background',
					responsive: true,
				},

				{
					selector: assembleSelector(getRootSelectorFor({ itemId })),
					variable: 'cartBadgeText',
					type: 'color:text',
					responsive: true,
				},
			],

			// transparent state
			transparentCartHeaderIconColor: [
				{
					selector: assembleSelector(
						mutateSelector({
							selector: mutateSelector({
								selector: getRootSelectorFor({ itemId }),
								operation: 'suffix',
								to_add: '> a',
							}),

							operation: 'between',
							to_add: '[data-transparent-row="yes"]',
						})
					),

					variable: 'linkInitialColor',
					type: 'color:default',
					responsive: true,
				},

				{
					selector: assembleSelector(
						mutateSelector({
							selector: mutateSelector({
								selector: getRootSelectorFor({ itemId }),
								operation: 'suffix',
								to_add: '> a',
							}),

							operation: 'between',
							to_add: '[data-transparent-row="yes"]',
						})
					),

					variable: 'linkHoverColor',
					type: 'color:hover',
					responsive: true,
				},
			],

			transparentCartBadgeColor: [
				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-transparent-row="yes"]',
						})
					),

					variable: 'cartBadgeBackground',
					type: 'color:background',
					responsive: true,
				},

				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-transparent-row="yes"]',
						})
					),

					variable: 'cartBadgeText',
					type: 'color:text',
					responsive: true,
				},
			],

			// sticky state
			stickyCartHeaderIconColor: [
				{
					selector: assembleSelector(
						mutateSelector({
							selector: mutateSelector({
								selector: getRootSelectorFor({ itemId }),
								operation: 'suffix',
								to_add: '> a',
							}),
							operation: 'between',
							to_add: '[data-sticky*="yes"]',
						})
					),
					variable: 'linkInitialColor',
					type: 'color:default',
					responsive: true,
				},

				{
					selector: assembleSelector(
						mutateSelector({
							selector: mutateSelector({
								selector: getRootSelectorFor({ itemId }),
								operation: 'suffix',
								to_add: '> a',
							}),
							operation: 'between',
							to_add: '[data-sticky*="yes"]',
						})
					),
					variable: 'linkHoverColor',
					type: 'color:hover',
					responsive: true,
				},
			],

			stickyCartBadgeColor: [
				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-sticky*="yes"]',
						})
					),
					variable: 'cartBadgeBackground',
					type: 'color:background',
					responsive: true,
				},

				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-sticky*="yes"]',
						})
					),
					variable: 'cartBadgeText',
					type: 'color:text',
					responsive: true,
				},
			],

			// panel
			cart_panel_width: {
				selector: '#woo-cart-panel',
				variable: 'side-panel-width',
				responsive: true,
				unit: '',
			},

			cart_panel_heading_font_color: {
				selector: '#woo-cart-panel .ct-panel-actions',
				variable: 'headingColor',
				type: 'color:default',
				responsive: true,
			},

			cart_panel_font_color: [
				{
					selector: '#woo-cart-panel .cart_list, #woo-cart-panel [class*="empty-message"]',
					variable: 'color',
					type: 'color:default',
					responsive: true,
				},

				{
					selector: '#woo-cart-panel .cart_list',
					variable: 'linkInitialColor',
					type: 'color:link_initial',
					responsive: true,
				},

				{
					selector: '#woo-cart-panel .cart_list',
					variable: 'linkHoverColor',
					type: 'color:link_hover',
					responsive: true,
				},
			],

			cart_panel_total_font_color: {
				selector: '#woo-cart-panel .total',
				variable: 'color',
				type: 'color:default',
				responsive: true,
			},

			cart_panel_shadow: {
				selector: '#woo-cart-panel',
				type: 'box-shadow',
				variable: 'box-shadow',
				responsive: true,
			},

			...handleBackgroundOptionFor({
				id: 'cart_panel_background',
				selector: '#woo-cart-panel > section',
				responsive: true,
			}),

			...handleBackgroundOptionFor({
				id: 'cart_panel_backdrop',
				selector: '#woo-cart-panel',
				responsive: true,
			}),

			cart_panel_close_button_color: [
				{
					selector: '#woo-cart-panel .close-button',
					variable: 'closeButtonColor',
					type: 'color:default',
				},

				{
					selector: '#woo-cart-panel .close-button',
					variable: 'closeButtonHoverColor',
					type: 'color:hover',
				},
			],

			cart_panel_close_button_shape_color: [
				{
					selector: '#woo-cart-panel .close-button',
					variable: 'closeButtonBackground',
					type: 'color:default',
				},

				{
					selector: '#woo-cart-panel .close-button',
					variable: 'closeButtonHoverBackground',
					type: 'color:hover',
				},
			],
		})
	}
)

ctEvents.on('ct:header:sync:item:cart', ({ optionId, optionValue, values }) => {
	const selector = '[data-id="cart"]'

	if (optionId === 'header_cart_visibility') {
		updateAndSaveEl(selector, (el) =>
			responsiveClassesFor({ ...optionValue, desktop: true }, el)
		)
	}

	if (optionId === 'has_cart_subtotal') {
		updateAndSaveEl(selector, (el) => {
			;[...el.querySelectorAll('.ct-cart-total')].map((el) => el.remove())

			if (optionValue === 'yes') {
				const span = document.createElement('span')
				span.innerHTML = el.dataset.subtotal

				span.classList.add('ct-cart-total')

				el.querySelector('a').prepend(span)
			}
		})
	}

	if (optionId === 'cart_subtotal_visibility') {
		updateAndSaveEl(selector, (el) => {
			;[...el.querySelectorAll('.ct-cart-total')].map((el) => {
				responsiveClassesFor(optionValue, el)
			})
		})
	}

	if (optionId === 'has_cart_badge') {
		updateAndSaveEl(selector, (el) => {
			el.firstElementChild.removeAttribute('data-skip-badge')
			if (optionValue === 'yes') return
			el.firstElementChild.dataset.skipBadge = ''
		})
	}

	if (optionId === 'mini_cart_type') {
		updateAndSaveEl(selector, (el) => {
			el.querySelector('a > .ct-cart-icon').innerHTML = svgs[optionValue]
		})
	}

	if (optionId === 'auto_open_cart') {
		updateAndSaveEl(selector, (el) => {
			el.querySelector('a').removeAttribute('data-auto-open')

			let components = []

			if (optionValue.archive) {
				components.push('archive')
			}

			if (optionValue.product) {
				components.push('product')
			}

			if (components.length > 0) {
				el.querySelector('a').dataset.autoOpen = components.join(':')
			}
		})
	}
})
