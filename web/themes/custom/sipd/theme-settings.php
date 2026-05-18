<?php

declare(strict_types=1);

use Drupal\Core\Form\FormStateInterface;

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function sipd_form_system_theme_settings_alter(array &$form, FormStateInterface $form_state): void {

  // ── HERO SECTION ──────────────────────────────────────────────────────────
  $form['sipd_hero'] = [
    '#type' => 'details',
    '#title' => t('Hero Section'),
    '#open' => TRUE,
  ];

  $form['sipd_hero']['hero_bg_image'] = [
    '#type' => 'textfield',
    '#title' => t('Background image URL'),
    '#description' => t('Full URL or path from the web root (e.g. /themes/custom/sipd/assets/imgs/hero-background.jpg). Leave blank to use the CSS default.'),
    '#default_value' => theme_get_setting('hero_bg_image') ?? '',
  ];

  $form['sipd_hero']['hero_show_overlay'] = [
    '#type' => 'checkbox',
    '#title' => t('Show overlay'),
    '#description' => t('Adds the overlay darkening class to the hero background image.'),
    '#default_value' => theme_get_setting('hero_show_overlay') ?? 1,
  ];

  $form['sipd_hero']['hero_contact_btn_text'] = [
    '#type' => 'textfield',
    '#title' => t('Contact button text'),
    '#default_value' => theme_get_setting('hero_contact_btn_text') ?? 'contact us',
  ];

  $form['sipd_hero']['hero_contact_btn_url'] = [
    '#type' => 'textfield',
    '#title' => t('Contact button URL'),
    '#default_value' => theme_get_setting('hero_contact_btn_url') ?? '/contact',
  ];

  $form['sipd_hero']['hero_address_text'] = [
    '#type' => 'textfield',
    '#title' => t('Address display text'),
    '#default_value' => theme_get_setting('hero_address_text') ?? '195 Bridgetown St, Staten Island, NY',
  ];

  $form['sipd_hero']['hero_address_url'] = [
    '#type' => 'textfield',
    '#title' => t('Address link URL'),
    '#default_value' => theme_get_setting('hero_address_url') ?? 'https://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=195+Bridgetown+Street+Staten+Island+NY+10314',
  ];

  $form['sipd_hero']['hero_phone_text'] = [
    '#type' => 'textfield',
    '#title' => t('Phone display text'),
    '#default_value' => theme_get_setting('hero_phone_text') ?? '(718) 761-7316',
  ];

  $form['sipd_hero']['hero_phone_number'] = [
    '#type' => 'textfield',
    '#title' => t('Phone number (digits only, used in tel: links)'),
    '#default_value' => theme_get_setting('hero_phone_number') ?? '7187617316',
  ];

  $form['sipd_hero']['hero_booking_url'] = [
    '#type' => 'textfield',
    '#title' => t('Online booking URL (mobile appointment button)'),
    '#default_value' => theme_get_setting('hero_booking_url') ?? '/contact',
  ];

  $form['sipd_hero']['hero_heading'] = [
    '#type' => 'textfield',
    '#title' => t('Hero heading'),
    '#default_value' => theme_get_setting('hero_heading') ?? 'Providing optimum dental care to your child in a friendly environment.',
  ];

  $form['sipd_hero']['hero_cta_text'] = [
    '#type' => 'textfield',
    '#title' => t('Hero CTA link text'),
    '#default_value' => theme_get_setting('hero_cta_text') ?? 'about our practice',
  ];

  $form['sipd_hero']['hero_cta_url'] = [
    '#type' => 'textfield',
    '#title' => t('Hero CTA link URL'),
    '#default_value' => theme_get_setting('hero_cta_url') ?? '/about-us',
  ];

  // ── FEATURED SECTION ──────────────────────────────────────────────────────
  $form['sipd_featured'] = [
    '#type' => 'details',
    '#title' => t('Featured Section'),
    '#open' => FALSE,
  ];

  $form['sipd_featured']['featured_bg_image'] = [
    '#type' => 'textfield',
    '#title' => t('Background image URL'),
    '#description' => t('Full URL or path from the web root (e.g. /themes/custom/sipd/assets/imgs/my-bg.jpg). Leave blank to use the CSS default.'),
    '#default_value' => theme_get_setting('featured_bg_image') ?? '',
  ];

  $form['sipd_featured']['featured_heading'] = [
    '#type' => 'textfield',
    '#title' => t('Heading'),
    '#default_value' => theme_get_setting('featured_heading') ?? 'Welcome to Staten Island Pediatric Dentistry',
  ];

  $form['sipd_featured']['featured_body_1'] = [
    '#type' => 'textarea',
    '#title' => t('Body paragraph 1'),
    '#rows' => 4,
    '#default_value' => theme_get_setting('featured_body_1') ?? 'Your child is precious to you, and they are precious to us too. It takes a special group of people to work exclusively with children, and that is exactly what you\'ll find at Staten Island Pediatric Dentistry.',
  ];

  $form['sipd_featured']['featured_body_2'] = [
    '#type' => 'textarea',
    '#title' => t('Body paragraph 2'),
    '#rows' => 4,
    '#default_value' => theme_get_setting('featured_body_2') ?? 'Many of us are parents too, and we know the level of trust required to put your child\'s care in anyone\'s hands but your own. Starting with your child\'s first interaction with our dental team, you will see how devoted we are to their comfort, safety, and well-being.',
  ];

  $form['sipd_featured']['featured_btn1_text'] = [
    '#type' => 'textfield',
    '#title' => t('Button 1 text'),
    '#default_value' => theme_get_setting('featured_btn1_text') ?? 'meet our team',
  ];

  $form['sipd_featured']['featured_btn1_url'] = [
    '#type' => 'textfield',
    '#title' => t('Button 1 URL'),
    '#default_value' => theme_get_setting('featured_btn1_url') ?? '/about-us',
  ];

  $form['sipd_featured']['featured_btn2_text'] = [
    '#type' => 'textfield',
    '#title' => t('Button 2 text'),
    '#default_value' => theme_get_setting('featured_btn2_text') ?? 'new patients',
  ];

  $form['sipd_featured']['featured_btn2_url'] = [
    '#type' => 'textfield',
    '#title' => t('Button 2 URL'),
    '#default_value' => theme_get_setting('featured_btn2_url') ?? '/first-visit',
  ];

  // ── OFFICE TOUR SECTION ───────────────────────────────────────────────────
  $form['sipd_office_tour'] = [
    '#type' => 'details',
    '#title' => t('Office Tour Section'),
    '#open' => FALSE,
  ];

  $form['sipd_office_tour']['office_tour_heading'] = [
    '#type' => 'textfield',
    '#title' => t('Section heading'),
    '#default_value' => theme_get_setting('office_tour_heading') ?? 'Office Tour',
  ];

  $form['sipd_office_tour']['office_tour_cta_text'] = [
    '#type' => 'textfield',
    '#title' => t('CTA link text'),
    '#default_value' => theme_get_setting('office_tour_cta_text') ?? 'view our photo gallery',
  ];

  $form['sipd_office_tour']['office_tour_cta_url'] = [
    '#type' => 'textfield',
    '#title' => t('CTA link URL'),
    '#default_value' => theme_get_setting('office_tour_cta_url') ?? '/gallery',
  ];

  $slide_alt_defaults = [
    1 => 'Reception area of Staten Island Pediatric Dentistry',
    2 => 'Waiting area of Staten Island Pediatric Dentistry',
    3 => 'Treatment room at Staten Island Pediatric Dentistry',
  ];

  for ($i = 1; $i <= 3; $i++) {
    $form['sipd_office_tour']["office_tour_slide_{$i}_image"] = [
      '#type' => 'textfield',
      '#title' => t('Slide @num — image URL or path', ['@num' => $i]),
      '#description' => t('Full URL or path from the web root. Leave blank to use the default theme image (slider-@num.jpg).', ['@num' => $i]),
      '#default_value' => theme_get_setting("office_tour_slide_{$i}_image") ?? '',
    ];
    $form['sipd_office_tour']["office_tour_slide_{$i}_alt"] = [
      '#type' => 'textfield',
      '#title' => t('Slide @num — image alt text', ['@num' => $i]),
      '#default_value' => theme_get_setting("office_tour_slide_{$i}_alt") ?? $slide_alt_defaults[$i],
    ];
  }

  // ── TESTIMONIALS SECTION ──────────────────────────────────────────────────
  $form['sipd_testimonials'] = [
    '#type' => 'details',
    '#title' => t('Testimonials Section'),
    '#open' => FALSE,
  ];

  $form['sipd_testimonials']['testimonials_heading'] = [
    '#type' => 'textfield',
    '#title' => t('Section heading'),
    '#default_value' => theme_get_setting('testimonials_heading') ?? 'What Our Patients Say About Us',
  ];

  $form['sipd_testimonials']['testimonials_splide_width'] = [
    '#type' => 'textfield',
    '#title' => t('Slider width'),
    '#description' => t('CSS value, e.g. 60vw, 100%, 800px.'),
    '#default_value' => theme_get_setting('testimonials_splide_width') ?? '60vw',
  ];

  $form['sipd_testimonials']['testimonials_splide_interval'] = [
    '#type' => 'number',
    '#title' => t('Auto-advance interval (milliseconds)'),
    '#min' => 1000,
    '#default_value' => theme_get_setting('testimonials_splide_interval') ?? 15000,
  ];

  $form['sipd_testimonials']['testimonials_cta_text'] = [
    '#type' => 'textfield',
    '#title' => t('CTA link text (shared across all slides)'),
    '#default_value' => theme_get_setting('testimonials_cta_text') ?? 'read our testimonials',
  ];

  $form['sipd_testimonials']['testimonials_cta_url'] = [
    '#type' => 'textfield',
    '#title' => t('CTA link URL'),
    '#default_value' => theme_get_setting('testimonials_cta_url') ?? '/testimonials',
  ];

  $testimonial_defaults = [
    1 => '"My children have always had a positive experience with Dr. Michelle and her staff. Everyone you encounter in the office is friendly and helpful. Dr. Michelle does everything she can to make children feel comfortable and takes time to explain procedures to them in ways they can understand. She also took time with me to explain the best options when I had to make a decision about how to handle my kids\' dental situations. I am very happy with their services and I highly recommend them!"',
    2 => '"Every so often you meet someone who has quite simply found their perfect niche in this crazy world. Dr. Michelle is one of those people. She is the best at what she does. My 3 year old is excited to visit the dentist. Michelle makes him feel valued and special and comfortable all while actually getting him to open his mouth and get his teeth cleaned! She remembers him (and me) from one visit to the next and genuinely cares about us as people not just clients. I cannot say enough complimentary things about Dr. Michelle and her practice. They are simply phenomenal and I will recommend them to anyone who will listen!"',
    3 => '"Brought my 5 year old daughter here and she absolutely loves It here!! As do i! Amazing staff! Dr Michelle is an absolute gem! My daughter had 2 cavities filled yesterday and they took such amazing care of my daughter she was so comfortable and can\'t wait to go back and that means a lot. Thank you so much for taking care of my little girl! If anyone has a child this is the place to go!"',
    4 => '"My daughter\'s first visit and it was a wonderful experience. Dr Michelle, Veronica and the staff were so thorough working and explaining everything along the way. And before I knew it, my daughter\'s loose teeth were both out. This felt like more than just a dental practice, it is an extended family taking care of my daughter. Thank you so much!!!"',
  ];

  for ($i = 1; $i <= 4; $i++) {
    $form['sipd_testimonials']["testimonials_slide_{$i}_body"] = [
      '#type' => 'textarea',
      '#title' => t('Testimonial @num', ['@num' => $i]),
      '#rows' => 5,
      '#default_value' => theme_get_setting("testimonials_slide_{$i}_body") ?? $testimonial_defaults[$i],
    ];
  }
}
