<template>

  <div class="bvnode-settings-panel">



    <div class="bvnode-ui-fields">
      <div class="bvnode-ui-fields__left">
        
      <div v-if="show_title" class="template-name">
      <div class="bvnode-settings-panel__headline">Template Name</div>
      <input type="text" v-model="title" class="template-name-input" maxlength="45" />
    </div>

<div class="bvnode-settings-panel__headline" style="width: 100%;">Template Settings</div>
        <label class="bvn-ui-label">
          <span class="bvn-ui-label__text">Font:</span>
          <select class="bvn-ui-label__select" v-model="settings.font">
            <option v-for="font in settings_fields.fonts" :key="font" :value="font">{{ font }}</option>
          </select>
        </label>
        <label class="bvn-ui-label">
          <span class="bvn-ui-label__text">Peper Size:</span>
          <select class="bvn-ui-label__select" v-model="settings.paper_size">
            <option v-for="paper_size in settings_fields.paper_sizes" :key="paper_size" :value="paper_size">
              {{ paper_size.toUpperCase() }}</option>
          </select>
        </label>
        <label class="bvn-ui-label">
          <span class="bvn-ui-label__text">Orientation:</span>
          <select class="bvn-ui-label__select" v-model="settings.orientation">
            <option v-for="orientation in settings_fields.orientations" :key="orientation" :value="orientation">
              {{ orientation }}</option>
          </select>
        </label>
        <label class="bvn-ui-label bvn-ui-label--checkbox">
          <span class="bvn-ui-label__text">Page Header</span>
          <input type="checkbox" class="checkbox-hidden" v-model="settings.page_header" v-on:change="checkTab('page_header')">
          <span class="checkbox-visible"></span>
        </label>
        <label class="bvn-ui-label bvn-ui-label--checkbox">
          <span class="bvn-ui-label__text">Page Footer</span>
          <input type="checkbox" class="checkbox-hidden" v-model="settings.page_footer" v-on:change="checkTab('page_footer')">
          <span class="checkbox-visible"></span>
        </label>
      </div>
      <div class="bvnode-ui-fields__right">
        <label class="bvn-ui-label bvn-ui-label--full">
          <span class="bvn-ui-label__text">Margins:</span>
          <div class="bvn-ui-label__orientation-wrapper">
            <div class="bvn-ui-label__orientation"
              :class="settings.orientation == 'portrait' ? 'bvn-ui-label__orientation--portrait' : 'bvn-ui-label__orientation--landscape'">
              <input type="number" v-model="settings.margins.top" min="0" max="120"  @change="settings.margins.top = Math.max(Math.min(Math.round(settings.margins.top), 120), 0)"  @keyup="settings.margins.top = Math.max(Math.min(Math.round(settings.margins.top), 120), 0)" />

              <input type="number" v-model="settings.margins.right" min="0" max="120"  @change="settings.margins.right = Math.max(Math.min(Math.round(settings.margins.right), 120), 0)"  @keyup="settings.margins.right = Math.max(Math.min(Math.round(settings.margins.right), 120), 0)" />

              <input type="number" v-model="settings.margins.bottom" min="0" max="120"  @change="settings.margins.bottom = Math.max(Math.min(Math.round(settings.margins.bottom), 120), 0)"  @keyup="settings.margins.bottom = Math.max(Math.min(Math.round(settings.margins.bottom), 120), 0)" />

              <input type="number" v-model="settings.margins.left" min="0" max="120"  @change="settings.margins.left = Math.max(Math.min(Math.round(settings.margins.left), 120), 0)"  @keyup="settings.margins.left = Math.max(Math.min(Math.round(settings.margins.left), 120), 0)" />
              <div class="bvn-ui-label__orientation-margin bvn-ui-label__orientation-margin--top"
                :style="{ 'height': settings.margins.top / 5 + 'px' }"></div>
              <div class="bvn-ui-label__orientation-margin bvn-ui-label__orientation-margin--right"
                :style="{ 'width': settings.margins.right / 5 + 'px' }"></div>
              <div class="bvn-ui-label__orientation-margin bvn-ui-label__orientation-margin--bottom"
                :style="{ 'height': settings.margins.bottom / 5 + 'px' }"></div>
              <div class="bvn-ui-label__orientation-margin bvn-ui-label__orientation-margin--left"
                :style="{ 'width': settings.margins.left / 5 + 'px' }"></div>
              <div class="bvn-ui-label__orientation-paper-size">
                {{ settings.paper_size.toUpperCase() }}
              </div>
            </div>
          </div>
        </label>
      </div>
    </div>

  </div>
  
  <ul class="bvnode-ui-tabs">
  <div class="bvnode-ui-tab" :class="{'bvnode-ui-tab--active' : tab == 'header' }" v-if="settings.page_header" v-on:click="changeTab('header')">
    Header Template
  </div>
  <div class="bvnode-ui-tab" :class="{'bvnode-ui-tab--active' : tab == 'main' }" v-on:click="changeTab('main')">
      Main Template
  </div>
  <div class="bvnode-ui-tab" :class="{'bvnode-ui-tab--active' : tab == 'footer' }" v-if="settings.page_footer" v-on:click="changeTab('footer')">
      Footer Template
  </div>
  <div class="bvnode-ui-tab" :class="{'bvnode-ui-tab--active' : tab == 'css' }" v-on:click="changeTab('css')">
      Stylesheet
  </div>
  </ul>
  
  <div class="bvnode-ui-tab-content" v-if="settings.page_header"  :class="{'bvnode-ui-tab-content--active' : tab == 'header' }">
    
      <div class="bvnode-code-editor-wrapper">

        <textarea class="bvnode-code-editor" v-model="header" theme="vs-light" language="html"
          automaticLayout="true" :options="options" @mount="handleMountHeader" />
      </div>
    </div>
    <div class="bvnode-ui-tab-content" :class="{'bvnode-ui-tab-content--active' : tab == 'main' }">
    <div class="bvnode-code-editor-wrapper">
      <textarea class="bvnode-code-editor" v-model="code" theme="vs-light" language="html"
        automaticLayout="true" :options="options" @mount="handleMount" />
    </div>
  </div>
  <div class="bvnode-ui-tab-content" v-if="settings.page_footer" :class="{'bvnode-ui-tab-content--active' : tab == 'footer' }">
    <div class="bvnode-code-editor-wrapper">
      <textarea class="bvnode-code-editor" v-model="footer" theme="vs-light" language="html"
        automaticLayout="true" :options="options" @mount="handleMountFooter" />
    </div>
  </div>
  <div class="bvnode-ui-tab-content" :class="{'bvnode-ui-tab-content--active' : tab == 'css' }">
    <div class="bvnode-code-editor-wrapper">
      <textarea class="bvnode-code-editor" v-model="css" theme="vs-light" language="css"
        automaticLayout="true" :options="options" @mount="handleMountCSS" />
    </div>
  </div>

</template>

<script>


export default {
  name: 'BVNodeTemplateEditor',
  props: ['html', 'config', 'headerhtml', 'footerhtml', 'styles', 'showtitle', 'posttitle'],
  components: {
  },
  data() {
    return {
      show_title: false,
      title: '',
      header: null,
      header_editor: null,
      code: null,
      tab: 'main',
      editor: null,
      footer: null,
      footer_editor: null,
      css: null,
      css_editor: null,
      settings_fields: {
        fonts: ['Helvetica', 'Times-Roman', 'Courier', 'DejaVu Sans', 'DejaVu Serif', 'DejaVu Sans Mono'],
        paper_sizes: ["a4", "letter"],
        //paper_sizes: ["4a0", "2a0", "a0", "a1", "a2", "a3", "a4", "a5", "a6", "a7", "a8", "a9", "a10", "b0", "b1", "b2", "b3", "b4", "b5", "b6", "b7", "b8", "b9", "b10", "c0", "c1", "c2", "c3", "c4", "c5", "c6", "c7", "c8", "c9", "c10", "ra0", "ra1", "ra2", "ra3", "ra4", "sra0", "sra1", "sra2", "sra3", "sra4", "letter", "half-letter", "legal", "ledger", "tabloid", "executive", "folio", "commercial #10 envelope", "catalog #10 1/2 envelope", "8.5x11", "8.5x14", "11x17"],
        orientations: ['portrait', 'landscape']
      },
      settings: {
        font: 'Helvetica',
        paper_size: 'a4',
        orientation: 'portrait',
        margins: {
          top: 60,
          right: 60,
          bottom: 60,
          left: 60
        },
        page_header: 0,
        page_footer: 0,
      },
      options: {
        automaticLayout: true,
        formatOnType: true,
        formatOnPaste: true,
      }
    }
  },
  methods: {
    changeTab(tab) {
      this.tab = tab;
    },
    checkTab(tab) {
      if (!this.settings[tab]) {
        this.tab = 'main';
      }
    },
    handleMount(editor) {
      this.editor = editor;
    },
    handleMountHeader(editor) {
      this.header_editor = editor;
    },
    handleMountFooter(editor) {
      this.footer_editor = editor;
    },
    handleMountCSS(editor) {
      this.css_editor = editor;
    },
    getCode() {
      return this.code;
    },
    getHeaderCode() {
      return this.header;
    },
    getFooterCode() {
      return this.footer;
    },
    getCSS() {
      return this.css;
    },
    getTitle() {
      return this.title;
    },
    getSettings() {
      return JSON.stringify(this.settings);
    },
    htmlDecode(input) {
      var doc = new DOMParser().parseFromString(input, "text/html");
      return doc.documentElement.textContent;
    }
  },
  created() {
    
    this.code = atob(this.html);
    this.header = atob(this.headerhtml);
    this.footer = atob(this.footerhtml);
    this.css = atob(this.styles);
    this.settings = Object.assign({}, this.settings, JSON.parse(atob(this.config)));
    this.show_title = this.showtitle;
    this.title = this.posttitle;
  },
  setup() {

    return {

    }
  }
}
</script>

<style>
body {
  background: #efefef;
}

.bvnode-settings-panel {
  background: #fff;
  border-radius: 10px;
  padding: 20px;
  margin-bottom: 20px;
}

.bvnode-code-editor-wrapper {
  margin: 15px 0;
  height: 600px;
  max-height: 90vh;
}

.bvnode-code-editor-wrapper__headline {
  font-size: 2em;
  margin-bottom: 1em;
}

.bvnode-code-editor {
  border-radius: 10px;
  overflow: hidden;
}

.bvnode-settings-panel__headline {
  font-size: 18px;
  margin-bottom: 10px;
}

.bvn-ui-fields {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  margin-bottom: 15px;
  padding-bottom: 15px;
  border-bottom: 1px solid #efefef;
}

.bvn-ui-label {
  width: calc(33.33333% - 10px);
  display: flex;
  gap: 5px;
  flex-direction: column;
}

.bvn-ui-label--full {
  width: 100%;
}

.bvn-ui-label__text {

  display: flex;
  gap: 10px;
  font-size: .9em;
  padding-left: 5px;
}

.wp-core-ui .bvn-ui-label__select {
  display: block;
  width: auto;
  padding: 0.5em 1em;
  border: 1px solid #efefef;
  background-color: #efefef;
  border-radius: 0.5em;
  align-self: normal;
  height: 42px;

}

.bvn-ui-label__orientation-wrapper {
  background: #efefef;
  border-radius: 10px;
  border: 0;
  padding: 60px 80px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.bvn-ui-label__orientation {
  position: relative;
  width: calc(210px / 2);
  height: calc(297px / 2);
  border: 2px solid #ccc;
  display: flex;
  align-items: center;
  justify-content: center;

  input {
    position: absolute;
    padding: 0.5em 1em;
    border: 1px solid #fff;
    background-color: #fff;
    border-radius: 0.5em;
    width: 60px;
    height: 42px;
    box-sizing: border-box;
  }

  input[type=number]::-webkit-inner-spin-button,
  input[type=number]::-webkit-outer-spin-button {

    opacity: 1;

  }

  input:nth-child(1) {
    bottom: calc(100% + 10px);
    left: calc(50% - 30px);
  }

  input:nth-child(2) {
    top: calc(50% - 21px);
    left: calc(100% + 10px);
  }

  input:nth-child(3) {
    top: calc(100% + 10px);
    left: calc(50% - 30px);
  }

  input:nth-child(4) {
    top: calc(50% - 21px);
    right: calc(100% + 10px);
  }
}

.bvn-ui-label__orientation--landscape {
  height: calc(210px / 2);
  width: calc(297px / 2);
}

.bvn-ui-label__orientation-paper-size {
  font-size: 32px;
  color: #ccc;
}

.bvnode-ui-fields {
  display: flex;
  gap: 15px;
}

.bvnode-ui-fields__left {
  display: flex;
  flex-wrap: wrap;
  width: 66.6%;
  gap: 15px;
    align-self: flex-start;
}

.bvnode-ui-fields__right {
  width: 33.3%;
}

.bvn-ui-label__orientation-margin {
  position: absolute;
  background: #ddd;
}

.bvn-ui-label__orientation-margin--top {
  top: 0;
  left: 0;
  width: 100%;
  height: 6px;
  max-height: 24px;
}

.bvn-ui-label__orientation-margin--right {
  top: 0;
  right: 0;
  height: 100%;
  width: 6px;
  max-width: 24px;

}

.bvn-ui-label__orientation-margin--bottom {
  bottom: 0;
  left: 0;
  width: 100%;
  height: 24px;
  max-height: 24px;

}

.bvn-ui-label__orientation-margin--left {
  top: 0;
  left: 0;
  height: 100%;
  width: 6px;
  max-width: 24px;
}
.bvnode-ui-tab-content {
  display: none;
}
.bvnode-ui-tab-content--active {
  display: block;
}
.bvnode-ui-tabs {
  display: flex;
  margin: 15px 0;
  padding: 0;
  gap: 15px;
}
.bvnode-ui-tab {
  padding: 0.5em 1em;
  border: 1px solid #fff;
  background-color: #fff;
  border-radius: 0.5em;
  align-self: normal;
  height: 42px;
  cursor: pointer;
  color: #000;
  display: flex;
  align-items: center;
  justify-content: center;
}
.bvnode-ui-tab--active {
  background: #424495;
  color: #fff;
}
input[type="checkbox"].checkbox-hidden {
  display: none;
}
.checkbox-visible {
  width: 56px;
  height: 32px;
  padding: 4px;
  box-sizing: border-box;
  border-radius: 16px;
  background: #efefef;
}
.checkbox-visible::before {
  content: '';
  display: block;
  width: 24px;
  height: 24px;
  background: #ddd;
  border-radius: 50%;
  margin-left: 0;
  transition: 125ms ease-in-out all;
}
.bvn-ui-label--checkbox {
  flex-direction: row-reverse;
  align-items: center;
  justify-content: flex-end;
  gap: 15px;
  cursor: pointer;
  
}
.checkbox-hidden:checked + .checkbox-visible::before { 
  transform: translateX(100%);
  background: #424495;
}
.template-name {
  width: 100%;
}
.template-name .template-name-input[type="text"] {

  display: block;
    width: auto;
    padding: 0.5em 1em;
    border: 1px solid #efefef;
    background-color: #efefef;
    border-radius: 0.5em;
    align-self: normal;
    height: 42px;
    width: 100%;
}
textarea.bvnode-code-editor {
    border: 0;
    width: 100%;
    height: 100%;
    padding: 15px;
}
</style>
