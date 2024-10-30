import { createApp } from 'vue'
import BVNodeTemplateEditor from './BVNodeTemplateEditor.vue'


const templateEditor = document.querySelector('[data-bvnode-template]');

const app = createApp(BVNodeTemplateEditor, {
  "html": templateEditor.getAttribute('data-bvnode-template-html'),
  "headerhtml": templateEditor.getAttribute('data-bvnode-template-headerhtml'), 
  "footerhtml": templateEditor.getAttribute('data-bvnode-template-footerhtml'),
  "config": templateEditor.getAttribute('data-bvnode-template-config'),
  "styles": templateEditor.getAttribute('data-bvnode-template-styles'),
  "showtitle": templateEditor.getAttribute('data-bvnode-template-showtitle'),
  "posttitle": templateEditor.getAttribute('data-bvnode-template-posttitle'),
});
document.querySelector('[data-bvnode-template]').vm = app.mount(templateEditor);


