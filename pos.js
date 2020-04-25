$( document ).ready(function() {
    let pos_full_text = $('[data-qa="resumes-search-wizard-pos-full_text"]');
    let pos_position = $('[data-qa="resumes-search-wizard-pos-position"]');
    let pos_education = $('[data-qa="resumes-search-wizard-pos-education"]');
    let pos_keywords = $('[data-qa="resumes-search-wizard-pos-keywords"]');
    let pos_workplaces = $('[data-qa="resumes-search-wizard-pos-workplaces"]');
    let pos_workplace_organization = $('[data-qa="resumes-search-wizard-pos-workplace_organization"]');
    let pos_workplace_position = $('[data-qa="resumes-search-wizard-pos-workplace_position"]');
    let pos_workplace_description = $('[data-qa="resumes-search-wizard-pos-workplace_description"]');

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
    });
});