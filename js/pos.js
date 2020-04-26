$( document ).ready(function() {
    let pos_full_text = $('[data-qa="resumes-search-wizard-pos-full_text"]');
    let pos_position = $('[data-qa="resumes-search-wizard-pos-position"]');
    let pos_education = $('[data-qa="resumes-search-wizard-pos-education"]');
    let pos_keywords = $('[data-qa="resumes-search-wizard-pos-keywords"]');
    let pos_workplaces = $('[data-qa="resumes-search-wizard-pos-workplaces"]');
    let pos_workplace_organization = $('[data-qa="resumes-search-wizard-pos-workplace_organization"]');
    let pos_workplace_position = $('[data-qa="resumes-search-wizard-pos-workplace_position"]');
    let pos_workplace_description = $('[data-qa="resumes-search-wizard-pos-workplace_description"]');

    let workplace_extra = $('.workplace_extra');
    let exp_period_all_time = $('[data-qa="resumes-search-wizard-exp_period-all_time"]');
    let exp_period_last_year = $('[data-qa="resumes-search-wizard-exp_period-last_year"]');
    let exp_period_last_three_years = $('[data-qa="resumes-search-wizard-exp_period-last_three_years"]');
    let exp_period_last_six_years = $('[data-qa="resumes-search-wizard-exp_period-last_six_years"]');
    let exp_company_size_any = $('[data-qa="resumes-search-wizard-exp_company_size-any"]');
    let exp_company_size_small = $('[data-qa="resumes-search-wizard-exp_company_size-small"]');
    let exp_company_size_medium = $('[data-qa="resumes-search-wizard-exp_company_size-medium"]');
    let exp_company_size_large = $('[data-qa="resumes-search-wizard-exp_company_size-large"]');





    pos_full_text.click(function(){
        pos_position.prop('checked', false);
        pos_education.prop('checked', false);
        pos_keywords.prop('checked', false);
        pos_workplaces.prop('checked', false);
        pos_workplace_organization.prop('checked', false);
        pos_workplace_position.prop('checked', false);
        pos_workplace_description.prop('checked', false);
    });

    pos_position.click(function(){
        if ($(this).is(':checked') && pos_education.is(':checked') && pos_keywords.is(':checked') &&
            pos_workplaces.is(':checked')) {
            pos_full_text.prop('checked', true);
            pos_position.prop('checked', false);
            pos_education.prop('checked', false);
            pos_keywords.prop('checked', false);
            pos_workplaces.prop('checked', false);
            pos_workplace_organization.prop('checked', false);
            pos_workplace_position.prop('checked', false);
            pos_workplace_description.prop('checked', false);
        } else {
            pos_full_text.prop('checked', false);
        }
        if (!$(this).is(':checked') && !pos_education.is(':checked') && !pos_keywords.is(':checked') && !pos_workplaces.is(':checked')) {
            pos_full_text.prop('checked', true);
        }
    });
    pos_education.click(function(){
        if ($(this).is(':checked') && pos_position.is(':checked') && pos_keywords.is(':checked') &&
            pos_workplaces.is(':checked')) {
            pos_full_text.prop('checked', true);
            pos_position.prop('checked', false);
            pos_education.prop('checked', false);
            pos_keywords.prop('checked', false);
            pos_workplaces.prop('checked', false);
            pos_workplace_organization.prop('checked', false);
            pos_workplace_position.prop('checked', false);
            pos_workplace_description.prop('checked', false);
        } else {
            pos_full_text.prop('checked', false);
        }
        if (!$(this).is(':checked') && !pos_position.is(':checked') && !pos_keywords.is(':checked') && !pos_workplaces.is(':checked')) {
            pos_full_text.prop('checked', true);
        }

    });
    pos_keywords.click(function(){
        if ($(this).is(':checked') && pos_position.is(':checked') && pos_education.is(':checked') &&
            pos_workplaces.is(':checked')) {
            pos_full_text.prop('checked', true);
            pos_position.prop('checked', false);
            pos_education.prop('checked', false);
            pos_keywords.prop('checked', false);
            pos_workplaces.prop('checked', false);
            pos_workplace_organization.prop('checked', false);
            pos_workplace_position.prop('checked', false);
            pos_workplace_description.prop('checked', false);
        } else {
            pos_full_text.prop('checked', false);
        }
        if (!$(this).is(':checked') && !pos_position.is(':checked') && !pos_education.is(':checked') && !pos_workplaces.is(':checked')) {
            pos_full_text.prop('checked', true);
        }

    });
    pos_workplaces.click(function () {
        if ($(this).is(':checked') && pos_position.is(':checked') && pos_education.is(':checked') &&
            pos_keywords.is(':checked')) {
            pos_full_text.prop('checked', true);
            pos_position.prop('checked', false);
            pos_education.prop('checked', false);
            pos_keywords.prop('checked', false);
            pos_workplaces.prop('checked', false);
            pos_workplace_organization.prop('checked', false);
            pos_workplace_position.prop('checked', false);
            pos_workplace_description.prop('checked', false);
        } else {
            pos_full_text.prop('checked', false);
        }
        if (!$(this).is(':checked') && !pos_position.is(':checked') && !pos_education.is(':checked') && !pos_keywords.is(':checked')) {
            pos_full_text.prop('checked', true);
        }
        if ($(this).is(':checked')) {
            pos_workplace_organization.prop('checked', true);
            pos_workplace_position.prop('checked', true);
            pos_workplace_description.prop('checked', true);
        } else {
            pos_workplace_organization.prop('checked', false);
            pos_workplace_position.prop('checked', false);
            pos_workplace_description.prop('checked', false);
        }
        if ($(this).is(':checked')) {
            workplace_extra.show();
        } else {
            workplace_extra.hide();
            exp_period_all_time.prop('checked', true);
            exp_period_last_year.prop('checked', false);
            exp_period_last_three_years.prop('checked', false);
            exp_period_last_six_years.prop('checked', false);
            exp_company_size_any.prop('checked', true);
            exp_company_size_small.prop('checked', false);
            exp_company_size_medium.prop('checked', false);
            exp_company_size_large.prop('checked', false);
        }


    });

    pos_workplace_organization.click(function(){
        if (!$(this).is(':checked') && !pos_workplace_position.is(':checked') && !pos_workplace_description.is(':checked')) {
            pos_workplaces.prop('checked', false)
        } else {
            pos_full_text.prop('checked', false);
            pos_workplaces.prop('checked', true);
        }
        if (!pos_position.is(':checked') && !pos_education.is(':checked') && !pos_keywords.is(':checked') && !pos_workplaces.is(':checked')) {
            pos_full_text.prop('checked', true);
        }
        if ($(this).is(':checked')) {
            workplace_extra.show();
        } else {
            if (!pos_workplaces.is(':checked')) {
                workplace_extra.hide();
                exp_period_all_time.prop('checked', true);
                exp_period_last_year.prop('checked', false);
                exp_period_last_three_years.prop('checked', false);
                exp_period_last_six_years.prop('checked', false);
                exp_company_size_any.prop('checked', true);
                exp_company_size_small.prop('checked', false);
                exp_company_size_medium.prop('checked', false);
                exp_company_size_large.prop('checked', false);
            }
        }
    });
    pos_workplace_position.click(function(){
        if (!$(this).is(':checked') && !pos_workplace_organization.is(':checked') && !pos_workplace_description.is(':checked')) {
            pos_workplaces.prop('checked', false)
        } else {
            pos_full_text.prop('checked', false);
            pos_workplaces.prop('checked', true);
        }
        if (!pos_position.is(':checked') && !pos_education.is(':checked') && !pos_keywords.is(':checked') && !pos_workplaces.is(':checked')) {
            pos_full_text.prop('checked', true);
        }
        if ($(this).is(':checked')) {
            workplace_extra.show();
        }  else {
            if (!pos_workplaces.is(':checked')) {
                workplace_extra.hide();
                exp_period_all_time.prop('checked', true);
                exp_period_last_year.prop('checked', false);
                exp_period_last_three_years.prop('checked', false);
                exp_period_last_six_years.prop('checked', false);
                exp_company_size_any.prop('checked', true);
                exp_company_size_small.prop('checked', false);
                exp_company_size_medium.prop('checked', false);
                exp_company_size_large.prop('checked', false);
            }
        }
    });
    pos_workplace_description.click(function(){
        if (!$(this).is(':checked') && !pos_workplace_organization.is(':checked') && !pos_workplace_position.is(':checked')) {
            pos_workplaces.prop('checked', false)
        } else {
            pos_full_text.prop('checked', false);
            pos_workplaces.prop('checked', true);
        }
        if (!pos_position.is(':checked') && !pos_education.is(':checked') && !pos_keywords.is(':checked') && !pos_workplaces.is(':checked')) {
            pos_full_text.prop('checked', true);
        }
        if ($(this).is(':checked')) {
            workplace_extra.show();
        }  else {
            if (!pos_workplaces.is(':checked')) {
                workplace_extra.hide();
                exp_period_all_time.prop('checked', true);
                exp_period_last_year.prop('checked', false);
                exp_period_last_three_years.prop('checked', false);
                exp_period_last_six_years.prop('checked', false);
                exp_company_size_any.prop('checked', true);
                exp_company_size_small.prop('checked', false);
                exp_company_size_medium.prop('checked', false);
                exp_company_size_large.prop('checked', false);
            }
        }
    });
});