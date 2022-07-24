<template>
    <div class="container my-5">
        <loading v-if="loading" :active.sync="loading" color="#32489e" loader="spinner"/>
        <div v-else class="row">
<!--            <div v-if="$page.props.flash.message"  class="alert alert-success alert-dismissible fade show" role="alert">-->
<!--                <strong>Success!</strong> {{ $page.props.flash.message }}.-->
<!--                <button type="button" class="close" data-dismiss="alert" aria-label="Close">-->
<!--                    <span aria-hidden="true">&times;</span>-->
<!--                </button>-->
<!--            </div>-->

            <div class="col-8">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>Create Resources</h1>
                    <a href="/resources">View all resources</a>
                </div>
                <form class="mt-5" @submit.prevent="submitForm" enctype="multipart/form-data">
                    <div class="mt-4">
                        <div class="form-group mb-3">
                            <label for="pdf_title">Pdf title</label>
                            <input type="text" id="pdf_title" v-model="form.pdf_title"  class="form-control"  placeholder="Pdf title">
                        </div>
                        <div class="custom-file mb-3">
                            <div class="">
                                <label for="customFile">Upload pdf</label>
                            </div>
                            <input type="file" @change="onChange" name="pdf_file" ref="pdf" id="customFile">
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="form-group mb-3">
                            <label for="snippet_title">Snippet title</label>
                            <input type="text" class="form-control" id="snippet_title" v-model="form.snippet_title" placeholder="snippet title">
                        </div>
                        <div class="form-group mb-3">
                            <label for="snippet_content">Snippet content</label>
                            <QuillEditor :options="editorOption"
                                         v-model:content="form.snippet_content"
                                         content="string"
                                         content-type="html"
                            />
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="form-group mb-3">
                            <label for="link_title">Link title</label>
                            <input type="text" class="form-control" id="link_title" v-model="form.link_title" placeholder="Link title">
                        </div>
                        <div class="form-group mb-3">
                            <label for="link">LinK</label>
                            <input type="text" class="form-control" id="link" v-model="form.link" placeholder="Link">
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" v-model="form.open_tab" class="custom-control-input mr-2" id="tab">
                            <label class="custom-control-label" for="tab">Open in a new tab</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import { QuillEditor } from '@vueup/vue-quill'
import Loading from 'vue-loading-overlay';

export default {
    name: 'Create',

    components: {
        QuillEditor,
        Loading
    },

    data: function () {
        return {
            loading: false,
            file: '',
            formErrors: [],
            form : {
                pdf_title: '',
                snippet_title: '',
                snippet_content: '',
                link_title: '',
                link: '',
                open_tab: false
            },
            editorOption: {
                theme: 'snow',
                placeholder: 'Add snippet...',
                modules: {
                    clipboard: {
                        allowed: {
                            tags: ['h1', 'h2', 'h3', 'p', 'a', 'b', 'strong', 'u', 's', 'i', 'br', 'ul', 'ol', 'li', 'span', 'blockquote'],
                            attributes: ['href', 'rel', 'target', 'class']
                        },
                        keepSelection: true,
                        substituteBlockElements: true,
                        magicPasteLinks: true,
                    },
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'script': 'sub' }, { 'script': 'super' }],
                        [{ 'color': [] }],
                        [{ 'align': [] }],
                        ['clean'],
                        ['link']
                    ],
                }
            },
        }
    },

    computed: {
        editor() {
            return this.$refs.myQuillEditor.quill
        }
    },

    methods: {
        onChange(e) {
            this.file = e.target.files[0];
        },

        submitForm: function () {
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            // form data
            const formData = new FormData();
            formData.append('file', this.file)
            formData.append('pdf_title', this.form.pdf_title)
            formData.append('snippet_title', this.form.snippet_title)
            formData.append('snippet_content', this.form.snippet_content)
            formData.append('link_title', this.form.link_title)
            formData.append('link', this.form.link)
            formData.append('open_tab', this.form.open_tab)

            this.loading = true
            axios.post('/resources', formData, config)
                .then(() => {
                    this.loading = false
                    this.clearForm()
                    this.$toast.show("Resource created successfully", {
                        type: "success",
                        duration: 3000,
                        position: "top-right",
                        dismissible: true
                    })
                })
                .catch(error => {
                    console.log(error.response)
                    this.formErrors = error.response.data.errors
                });
        },

        clearForm: function () {
                this.form.pdf_title = ''
                this.form.snippet_title = ''
                this.form.snippet_content = ''
                this.form.link_title = ''
                this.form.link = ''
                this.form.open_tab = false
                this.file = ''
        }
    }
}
</script>
