<div ng-controller="ConfigController">
    <h2>IVR Configurator</h2>
    <div class="container">
        <div id="toolbarContainer"></div>
        <div id="outlineContainer" style="height:1000px;background:transparent;border-style:solid;border-color:lightgray;"></div>
    </div>
    <!-- modal DTMF Options form -->
    <div class="modal" id="dtmf-modal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" data-target="#dtmf-modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">DTMF Options</h4>
          </div>
          <div class="modal-body">
            <div id="holder" class="col-md-12">
              <div class="well">
                <form id="frmeditdtmf" name="frmeditdtmf" class="form-horizontal">
                  <!-- TAB MENU -->
                  <uib-tabset active="active">
                    <uib-tab index="0">
                      <uib-tab-heading>
                        <i class="fa fa-edit"></i> DTMF Settings
                      </uib-tab-heading>
                      <fieldset>
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="dtmfprompt">Prompt</label>
                          <div class="col-md-8">
                            <textarea id="dtmfprompt" maxlength="500" ng-model="dtmf.options.prompt" name="dtmfprompt"  placeholder="prompt" class="form-control input-md" required></textarea>
                          </div>
                        </div>
                        <div class="form-group" >
                          <label class="col-md-4 control-label" for="dtmfinvalid-prompt">Invalid Prompt</label>
                          <div class="col-md-8">
                            <input id="dtmfinvalid-prompt" maxlength="500" ng-model="dtmf.options.invalid_prompt" name="dtmfinvalid-prompt" type="text" placeholder="invalid-prompt" class="form-control input-md" required>
                          </div>
                        </div>
                        <div class="form-group" >
                          <label class="col-md-4 control-label" for="min-digits">Min Digits</label>
                          <div class="col-md-8">
                            <input id="min-digits"  name="min-digits" maxlength="500" type="number" step="1" min="1" ng-model="dtmf.options.min_digits" placeholder="min-digits" class="form-control input-md">
                          </div>
                        </div>
                        <div class="form-group" >
                          <label class="col-md-4 control-label" for="max-digits">Max Digits</label>
                          <div class="col-md-8">
                            <input id="max-digits"  name="max-digits" maxlength="500" type="number" step="1" min="1" ng-model="dtmf.options.max_digits" placeholder="max-digits" class="form-control input-md">
                          </div>
                        </div>
                        <div class="form-group" >
                          <label class="col-md-4 control-label" for="max-attempts">Max Attempts</label>
                          <div class="col-md-8">
                            <input id="max-attempts"  name="max-attempts" maxlength="500" type="number" step="1" value="4"  ng-model="dtmf.options.max_attempts" placeholder="max-attempts" class="form-control input-md">
                          </div>
                        </div>
                        <div class="form-group" >
                          <label class="col-md-4 control-label" for="terminators">Terminators</label>
                          <div class="col-md-8">
                            <input id="terminators" name="terminators" maxlength="500" type="text"  ng-model="dtmf.options.terminators" placeholder="terminators" class="form-control input-md">
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="regex">Regex</label>
                          <div class="col-md-8">
                            <input data-ng-model="dtmf.options.regex" value="[1-9]\\d*" type="text" name="regex" id="regex" placeholder="regex" class="form-control input-md" >
                          </div>
                        </div>
                      </fieldset>
                    </uib-tab>
                  </uib-tabset>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal" data-target="#dtmf-modal"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
              <button type="button" id="btnsave" ng-click="save_dtmf()" name="btnsave" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
            </div>
          </div>
        </div>
                </div>
        </div>

        <!-- EOF modal DTMF Optionsform -->
    <!-- modal Record Options form -->
    <div class="modal" id="record-modal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" data-target="#record-modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Record Options</h4>
          </div>
          <div class="modal-body">
            <div id="holder" class="col-md-12">
              <div class="well">
                <form id="frmeditrecord" name="frmeditrecord" class="form-horizontal">
                  <!-- TAB MENU -->
                  <uib-tabset active="active">
                    <uib-tab index="0">
                      <uib-tab-heading>
                        <i class="fa fa-edit"></i> Record Settings
                      </uib-tab-heading>
                      <fieldset>
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="dtmfprompt">Prompt</label>
                          <div class="col-md-8">
                            <input id="recordprompt" maxlength="500" ng-model="record.options.prompt" name="recordprompt" type="text" placeholder="prompt" class="form-control input-md" required>
                          </div>
                        </div>
                        <div class="form-group" >
                          <label class="col-md-4 control-label" for="playprompttype">Prompt Type</label>
                          <div class="col-md-8">
                            <input id="recordprompttype" maxlength="500" ng-model="record.options.prompt_type" name="recordprompttype" type="text"  class="form-control input-md" required disabled>
                          </div>
                        </div>
                        <div class="form-group" >
                          <label class="col-md-4 control-label" for="max-recording-time">Max Recording Time in Seconds</label>
                          <div class="col-md-8">
                            <input id="max-recording-time"  name="max-recording-time" maxlength="500" type="number" step="1" min="1" max="120" ng-model="record.options.max_recording_time" placeholder="max-recording-time" class="form-control input-md">
                          </div>
                        </div>
                        <div class="form-group" >
                          <label class="col-md-4 control-label" for="max-digits">Silence Time in Seconds</label>
                          <div class="col-md-8">
                            <input id="silence-time"  name="silence-time" maxlength="500" type="number" step="1" min="1" max="30" ng-model="record.options.silence_time" placeholder="silence time" class="form-control input-md">
                          </div>
                        </div>
                        <div class="form-group" >
                          <label class="col-md-4 control-label" for="terminators">Terminators</label>
                          <div class="col-md-8">
                            <input id="terminators" name="terminators" maxlength="500" type="text"  ng-model="record.options.terminators" placeholder="terminators" class="form-control input-md">
                          </div>
                        </div>
                      </fieldset>
                    </uib-tab>
                  </uib-tabset>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal" data-target="#record-modal"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
              <button type="button" id="btnsave" ng-click="save_record()" name="btnsave" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
            </div>
          </div>
        </div>
                </div>
        </div>

        <!-- EOF modal DTMF Optionsform -->
    <!-- modal Play Options form -->
    <div class="modal" id="play-modal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" data-target="#play-modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Play Options</h4>
          </div>
          <div class="modal-body">
            <div id="holder" class="col-md-12">
              <div class="well">
                <form id="frmeditplay" name="frmeditplay" class="form-horizontal">
                  <!-- TAB MENU -->
                  <uib-tabset active="active">
                    <uib-tab index="0">
                      <uib-tab-heading>
                        <i class="fa fa-edit"></i> Play Settings
                      </uib-tab-heading>
                      <fieldset>
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="dtmfprompt">Prompt</label>
                          <div class="col-md-8">
                            <input id="playprompt" maxlength="500" ng-model="play.options.prompt" name="playprompt" type="text" placeholder="prompt" class="form-control input-md" required>
                          </div>
                        </div>
                        <div class="form-group" >
                          <label class="col-md-4 control-label" for="playprompttype">Prompt Type</label>
                          <div class="col-md-8">
                            <input id="playprompttype" maxlength="500" ng-model="play.options.prompt_type" name="playprompttype" type="text"  class="form-control input-md" required disabled>
                          </div>
                        </div>
                        <div class="form-group" >
                          <label class="col-md-4 control-label" for="terminators">Terminators</label>
                          <div class="col-md-8">
                            <input id="terminators" name="terminators" maxlength="500" type="text"  ng-model="play.options.terminators" placeholder="terminators" class="form-control input-md">
                          </div>
                        </div>
                      </fieldset>
                    </uib-tab>
                  </uib-tabset>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal" data-target="#play-modal"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
              <button type="button" id="btnsave" ng-click="save_play()" name="btnsave" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
            </div>
          </div>
        </div>
        </div>
        </div>

        <!-- EOF modal Play Optionsform -->
    <!-- modal Spell Options form -->
    <div class="modal" id="spell-modal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" data-target="#spell-modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Spell Options</h4>
          </div>
          <div class="modal-body">
            <div id="holder" class="col-md-12">
              <div class="well">
                <form id="frmeditspell" name="frmeditspell" class="form-horizontal">
                  <!-- TAB MENU -->
                  <uib-tabset active="active">
                    <uib-tab index="0">
                      <uib-tab-heading>
                        <i class="fa fa-edit"></i> Spell Settings
                      </uib-tab-heading>
                      <fieldset>
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="dtmfprompt">Code</label>
                          <div class="col-md-8">
                            <input id="spellprompt" maxlength="500" ng-model="spell.options.code" name="spellprompt" type="text" placeholder="code" class="form-control input-md" required>
                          </div>
                        </div>
                        <div class="form-group" >
                          <label class="col-md-4 control-label" for="playprompttype">Code Type</label>
                          <div class="col-md-8">
                            <input id="spelltype" maxlength="500" ng-model="spell.options.code_type" name="spellprompttype" type="text"  class="form-control input-md" required disabled>
                          </div>
                        </div>
                      </fieldset>
                    </uib-tab>
                  </uib-tabset>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal" data-target="#spell-modal"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
              <button type="button" id="btnsave" ng-click="save_spell()" name="btnsave" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
            </div>
          </div>
        </div>
        </div>
        </div>

        <!-- EOF modal Spell Optionsform -->
    <!-- modal DTMF Logic Options form -->
    <div class="modal" id="dtmfl-modal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" data-target="#dtmfl-modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">DTMF Logic Options</h4>
          </div>
          <div class="modal-body">
            <div id="holder" class="col-md-12">
              <div class="well">
                <form id="frmeditdtmfl" name="frmeditdtmfl" class="form-horizontal">
                  <!-- TAB MENU -->
                  <uib-tabset active="active">
                    <uib-tab index="0">
                      <uib-tab-heading>
                        <i class="fa fa-edit"></i> DTMF Logic Settings
                      </uib-tab-heading>
                      <fieldset>
                        <div class="form-group">
                          <label class="col-md-4 control-label" for="dtmfvalue">DTMF Value to Match</label>
                          <div class="col-md-8">
                            <input id="dtmflvalue" maxlength="500" ng-model="dtmfl.options.value" name="dtmflvalue" type="text" placeholder="value" class="form-control input-md" required>
                          </div>
                        </div>
                      </fieldset>
                    </uib-tab>
                  </uib-tabset>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal" data-target="#dtmfl-modal"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
              <button type="button" id="btnsave" ng-click="save_dtmfl()" name="btnsave" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Save</button>
            </div>
          </div>
        </div>
        </div>
        </div>

        <!-- EOF modal DTMF Logic Optionsform -->
</div>


