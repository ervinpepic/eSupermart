<?php
/**
 * WooCommerce Onboarding
 * NOTE: DO NOT edit this file in WooCommerce core, this is generated from woocommerce-admin.
 */

namespace Automattic\WooCommerce\Internal\Admin\Onboarding;

/**
 * Initializes backend logic for the onboarding process.
 */
class Onboarding {
	/**
	 * Initialize onboarding functionality.
	 */
	public static function init() {
		OnboardingHelper::instance()->init();
		OnboardingIndustries::init();
		OnboardingJetpack::instance()->init();
		OnboardingMailchimp::instance()->init();
		OnboardingProfile::init();
		OnboardingSetupWizard::instance()->init();
		OnboardingSync::instance()->init();
		OnboardingThemes::init();
	}
}