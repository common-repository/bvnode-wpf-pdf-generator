
const form = document.querySelector('[action="options.php"]');

form.addEventListener("formdata", e => {


    e.formData.append("bvnode_wpf_pdf_generator_template_id",template_object.edit);
    e.formData.append("bvnode_wpf_pdf_generator_template_post_title", document.querySelector('[data-bvnode-template]').vm.getTitle());
    e.formData.append("bvnode_wpf_pdf_generator_template_data[bvnode_wpf_pdf_generator_template_template]", document.querySelector('[data-bvnode-template]').vm.getCode());
    e.formData.append("bvnode_wpf_pdf_generator_template_data[bvnode_wpf_pdf_generator_template_header]", document.querySelector('[data-bvnode-template]').vm.getHeaderCode());
    e.formData.append("bvnode_wpf_pdf_generator_template_data[bvnode_wpf_pdf_generator_template_footer]", document.querySelector('[data-bvnode-template]').vm.getFooterCode());
    e.formData.append("bvnode_wpf_pdf_generator_template_data[bvnode_wpf_pdf_generator_template_settings]", document.querySelector('[data-bvnode-template]').vm.getSettings());
    e.formData.append("bvnode_wpf_pdf_generator_template_data[bvnode_wpf_pdf_generator_template_css]", document.querySelector('[data-bvnode-template]').vm.getCSS());

    if (form.classList.contains('preview')) {
        e.formData.append("bvnode_wpf_pdf_generator_template_preview", 'preview');

    }
});