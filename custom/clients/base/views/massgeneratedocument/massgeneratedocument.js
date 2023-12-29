

// Ver /jssource/src_files/clients/base/views/massupdate/massupdate.js
// Ver /jssource/src_files/clients/base/views/massaddtolist/massaddtolist.js

({

   extendsFrom: 'MassupdateView',
   className: 'extend',

   initialize: function(options) {
      var additionalEvents = {};
      additionalEvents['click .btn[name=generatedocument_button]'] = 'MMR_generatedocument';
      additionalEvents['click .btn[name=generatedocumentpdf_button]'] = 'MMR_generatedocumentpdf';
      this.events = _.extend({}, this.events, additionalEvents);
        
      this._super("initialize", [options]);
   },

   delegateListFireEvents: function() {
      this.layout.on("list:massgeneratedocument:fire", this.show, this);
      this.layout.on("list:massaction:hide", this.hide, this);
   },


   setMetadata: function(options) {
      this.MMR_loadFormData(options);
   },

   _render: function() {
      var result = this._super("_render");

      return result;
   },
   
   show: function() {
      this._super("show");
      this.checkAttachToNoteAvailavility();
   },
   
   checkAttachToNoteAvailavility: function() {
      if (this.$('#MMR_AttachToNoteGeneratedDocument').length > 0) {
         var massUpdate = this.context.get('mass_collection');
         if (massUpdate.isEmpty() || massUpdate.fetched === false || massUpdate.length > 1) {
            this.$('#MMR_AttachToNoteGeneratedDocument').prop('checked', false);
            this.$('#MMR_AttachToNoteGeneratedDocument').hide();
            this.$('#MMR_AttachToNoteGeneratedDocument_label').hide();
         }
         else {
            if (massUpdate.length == 1) {
               this.$('#MMR_AttachToNoteGeneratedDocument_label').show();
               this.$('#MMR_AttachToNoteGeneratedDocument').show();
            }
         }
      } 
   },
   
   disableButtons: function(){
      this.$('.btn[name=generatedocument_button]').addClass('disabled');
      this.$('.btn[name=generatedocumentpdf_button]').addClass('disabled');   
   },
   
   enableButtons: function(){
      this.$('.btn[name=generatedocument_button]').removeClass('disabled');
      this.$('.btn[name=generatedocumentpdf_button]').removeClass('disabled');   
   },   
   
   setDisabled: function() {
      var massUpdate = this.context.get('mass_collection');
      if (massUpdate.isEmpty() || massUpdate.fetched === false) {
         this.disableButtons();
      } 
      else {
         this.enableButtons();
      }
      
      this.checkAttachToNoteAvailavility();      
   },
    
   MMR_generatedocument_process: function(inPDF) {
      var massGenerateDocumentList = this.context.get("mass_collection");

      if (massGenerateDocumentList) {
         this.disableButtons();
         app.alert.show('massGenerateDocumentList_loading', {level: 'process', title: app.lang.getAppString('LBL_LOADING')});
                  
         var recordListUrl = app.api.buildURL(this.module, 'record_list');
         var self = this;
             
         var api_call_params = {};
         api_call_params['uid'] = massGenerateDocumentList.pluck('id');
         api_call_params['pdf'] = inPDF;
         api_call_params['template_id'] = $("input[type=radio][name=MMR_plantilladocumento_id]:checked").val();
         api_call_params['attach_to_email'] = $("input[type=checkbox][name=MMR_AttachToEmailGeneratedDocument]").is(":checked");
         api_call_params['attach_to_note'] = $("input[type=checkbox][name=MMR_AttachToNoteGeneratedDocument]").is(":checked");
         api_call_params['viewName'] = 'list';
         
         return app.api.call(
            'create',
            recordListUrl,
            {'records': api_call_params.uid},
            {
               success: function(response) {
                  api_call_params = _.omit(api_call_params, ['uid']);
                  api_call_params['record_list_id'] = response.id;
                  api_call_params['platform'] = app.config.platform;
                  
                  if (api_call_params['attach_to_email']) {
                  
                     var url = app.api.buildURL(self.module, 'MMR_GenerateDocument_ATEmail', {}, api_call_params);
                     
                     app.api.call("read", url, null, {
                        success: function(data) {
                           app.alert.dismiss('massGenerateDocumentList_loading');
                           url = '#' + app.bwc.buildRoute('DHA_PlantillasDocumentos', null, 'composeEmail', {
                              return_module: self.model.module,
                              recordId: data.email_id
                           });
                           app.router.navigate(url, {trigger: true}); 
                        },
                        complete: function(data) {
                           app.alert.dismiss('massGenerateDocumentList_loading');
                           self.enableButtons();
                        }
                     });
                  }
                  if (api_call_params['attach_to_note']) {
                  
                     var url = app.api.buildURL(self.module, 'MMR_GenerateDocument_ATNote', {}, api_call_params);
                     
                     app.api.call("read", url, null, {
                        success: function(data) {
                           app.alert.dismiss('massGenerateDocumentList_loading');
                           url = app.router.buildRoute('Notes', data.note_id);
                           app.router.navigate(url, {trigger: true}); 
                        },
                        complete: function(data) {
                           app.alert.dismiss('massGenerateDocumentList_loading');
                           self.enableButtons();
                        }
                     });
                  }                  
                  else {
                  
                     var url = app.api.buildURL(self.module, 'MMR_GenerateDocument', {}, api_call_params);
                     var callbacks = {
                           complete: function(data) {
                              app.alert.dismiss('massGenerateDocumentList_loading');
                              self.enableButtons();
                           },
                           error: function(data) {
                              app.error.handleHttpError(data, {});
                           }
                     };
                     
                     app.api.fileDownload(
                        url,
                        callbacks,
                        { iframe: self.$el }
                     );
                  }
               }
            }
         );
      }
   },
    
   MMR_generatedocument: function() {
      if(this.$(".btn[name=generatedocument_button]").hasClass("disabled") === false) {
         this.MMR_generatedocument_process(false);
      }
   },
    
   MMR_generatedocumentpdf: function() {
      if(this.$(".btn[name=generatedocumentpdf_button]").hasClass("disabled") === false) {
         this.MMR_generatedocument_process(true);
      }
   },    
    
   MMR_loadFormData: function(params) {
      if (this.disposed) {
         return;
      }        
      params = params || {};
      
      var url_params = {};
      url_params['viewName'] = 'list'; 
      
      var url = app.api.buildURL(params.module, 'MMR_GetFormParams', {}, url_params),
          self = this;
      
      app.api.call("read", url, null, {
         success: function(data) {
            if(self.disposed) {
                return;
            }
            
            self.massdocform_code = data.massdocform_code;
            self.massdocform_can_generate_something = data.can_generate_something;
            self.massdocform_can_generate_documents = data.can_generate_documents;
            self.massdocform_can_generate_pdf_documents = data.can_generate_pdf_documents;
            self.massdocform_templates_count = data.templates_count;
            
            Handlebars.registerHelper('MMR_can_show_button', function(button_name, options) {
               var show_button = true;
               
               if (button_name == 'generatedocument_button') {
                  show_button = self.massdocform_can_generate_documents && (self.massdocform_templates_count > 0);
               }
               else if (button_name == 'generatedocumentpdf_button') {
                  show_button = self.massdocform_can_generate_pdf_documents && (self.massdocform_templates_count > 0);
               }
               
               return show_button ? options.fn(this) : options.inverse(this);
            });
            
            self.render();
         },
         complete: params ? params.complete : null
      });
   }    
    
})
