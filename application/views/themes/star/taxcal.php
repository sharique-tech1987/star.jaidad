<form name="cp_calculatedfieldsf_pform_1" id="cp_calculatedfieldsf_pform_1" action="?" method="post" enctype="multipart/form-data" class="cp_cff_11" novalidate="novalidate" data-evalequations="1" data-evalequationsevent="2" autocomplete="on"><input type="hidden" name="cp_calculatedfieldsf_id" value="7"><pre style="display:none !important;"><script type="text/javascript">form_structure_1=[[{"form_identifier":"","name":"separator1","shortlabel":"","index":0,"ftype":"fSectionBreak","userhelp":"","userhelpTooltip":false,"csslayout":"","title":"Advance Withholding Tax Calculation","fBuild":{},"parent":""},{"form_identifier":"","name":"fieldname2","shortlabel":"","index":1,"ftype":"fnumber","userhelp":"","userhelpTooltip":false,"csslayout":"","title":"Enter the FBR Value of your property","predefined":"Enter the FBR value of your property","predefinedClick":false,"required":false,"readonly":false,"size":"medium","thousandSeparator":"","decimalSymbol":".","min":"","max":"","formatDynamically":false,"dformat":"digits","formats":["digits","number"],"fBuild":{},"parent":""},{"form_identifier":"","name":"fieldname6","shortlabel":"","index":2,"ftype":"fnumber","userhelp":"","userhelpTooltip":false,"csslayout":"","title":"Enter the DC value of your property","predefined":"","predefinedClick":false,"required":false,"readonly":false,"size":"medium","thousandSeparator":"","decimalSymbol":".","min":"","max":"","formatDynamically":false,"dformat":"digits","formats":["digits","number"],"fBuild":{},"parent":""},{"form_identifier":"","name":"fieldname21","shortlabel":"","index":3,"ftype":"fdropdown","userhelp":"","userhelpTooltip":false,"csslayout":"","title":"Select if you are filer or non-filer. ","size":"medium","required":false,"toSubmit":"text","merge":0,"choiceSelected":"","multiple":false,"vChoices":1,"showDep":false,"choices":["Filer","Non Filer"],"choicesVal":["100","50"],"choicesDep":[[],[]],"fBuild":{},"parent":"","optgroup":[false,false]},{"form_identifier":"","name":"fieldname24","shortlabel":"","index":4,"ftype":"fPageBreak","userhelp":"","userhelpTooltip":false,"csslayout":"","title":"Page Break","fBuild":{},"parent":""},{"dependencies":[{"rule":"value\u003C80000","complex":false,"fields":[""]}],"form_identifier":"","name":"fieldname1","shortlabel":"","index":5,"ftype":"fCalculated","userhelp":"","userhelpTooltip":false,"csslayout":"","title":"Total Advance Tax ","predefined":"0","required":false,"size":"medium","toolbar":"default|mathematical","eq":"fieldname2\/fieldname21*1","suffix":"","prefix":"","decimalsymbol":".","groupingsymbol":"","readonly":true,"hidefield":false,"fBuild":{},"parent":"","predefinedClick":false,"items":{"fieldname2":{"label":"Enter the FBR Value of your property","type":"fnumber"},"fieldname6":{"label":"Enter the DC value of your property","type":"fnumber"},"fieldname21":{"label":"Select if you are filer or non-filer. ","type":"fdropdown"},"fieldname30":{"label":"3% Difference of FBR Value and DC Rate ","type":"fCalculated"},"fieldname7":{"label":"Total CVT & Stamp Duty ","type":"fCalculated"},"fieldname16":{"label":"Grand Total","type":"fCalculated"}}},{"dependencies":[{"rule":"","complex":false,"fields":[""]}],"form_identifier":"","name":"fieldname7","shortlabel":"","index":6,"ftype":"fCalculated","userhelp":"","userhelpTooltip":false,"csslayout":"","title":"Total CVT & Stamp Duty ","predefined":"","required":false,"size":"medium","toolbar":"default|mathematical","eq":"fieldname6\/100*5","suffix":"","prefix":"","decimalsymbol":".","groupingsymbol":"","readonly":true,"hidefield":false,"fBuild":{},"parent":""},{"form_identifier":"","name":"fieldname19","shortlabel":"","index":7,"ftype":"fSectionBreak","userhelp":"","userhelpTooltip":false,"csslayout":"","title":"Total Tax Payable ","fBuild":{},"parent":""},{"dependencies":[{"rule":"","complex":false,"fields":[""]}],"form_identifier":"","name":"fieldname16","shortlabel":"","index":8,"ftype":"fCalculated","userhelp":"","userhelpTooltip":false,"csslayout":"","title":"Grand Total","predefined":"","required":false,"size":"medium","toolbar":"default|mathematical","eq":"fieldname1+fieldname7","suffix":"","prefix":"","decimalsymbol":".","groupingsymbol":"","readonly":true,"hidefield":false,"fBuild":{},"parent":"","items":{"fieldname2":{"label":"Enter the FBR Value of your property","type":"fnumber"},"fieldname6":{"label":"Enter the DC value of your property","type":"fnumber"},"fieldname21":{"label":"Select if you are filer or non-filer. ","type":"fdropdown"},"fieldname1":{"label":"Total Advance Tax ","type":"fCalculated"},"fieldname7":{"label":"Total CVT & Stamp Duty ","type":"fCalculated"}}}],{"0":{"title":"Buyers Tax Calculator Pakistan Property","description":"","formlayout":"top_aligned","formtemplate":"cp_cff_11","evalequations":1,"autocomplete":1,"evalequationsevent":2,"persistence":0,"customstyles":""},"formid":"cp_calculatedfieldsf_pform_1"}];</script></pre>
    <div id="fbuilder">
        <div id="fbuilder_1">
            <div id="formheader_1"><div class="fform" id="field">
                    <h2 style="text-align: center;">Buyers Tax Calculator Pakistan Property</h2><span></span></div>
            </div>
            <div id="fieldlist_1" class="top_aligned">
                <div class=" col-lg-6 pb0 pbreak" page="0" style="display: block;">
                    <fieldset>
<!--                        <legend>Page 1 of 2</legend>-->
                        <div class="fields  separator1_1 section_breaks" id="field_1-0">
                            <div class="section_break" id="separator1_1"></div>
                            <h4>Advance Withholding Tax Calculation</h4>
                            <span class="uh"></span>
                            <div class="clearer"></div>
                        </div>
                        <div class="fields  fieldname2_1 cff-number-field" id="field_1-1">
                            <label for="fieldname2_1">Enter the FBR Value of your property</label>
                            <div class="dfield">
                                <input id="fieldname2_1" name="fieldname2_1" class="field digits medium valid" type="number" value="Enter the FBR value of your property" aria-invalid="false">
                                <span class="uh"></span>
                            </div>
                            <div class="clearer"></div>
                        </div>
                        <div class="fields  fieldname6_1 cff-number-field" id="field_1-2">
                            <label for="fieldname6_1">Enter the DC value of your property</label>
                            <div class="dfield">
                                <input id="fieldname6_1" name="fieldname6_1" class="field digits medium valid" type="number" value="">
                                <span class="uh"></span>
                            </div>
                            <div class="clearer"></div>
                        </div>
                        <div class="fields  fieldname21_1 cff-dropdown-field" id="field_1-3">
                            <label for="fieldname21_1">Select if you are filer or non-filer. </label>
                            <div class="dfield"><select id="fieldname21_1" name="fieldname21_1" class="field medium valid" aria-invalid="false">
                                    <option value="100" vt="Filer" data-i="0">Filer</option>
                                    <option value="50" vt="Non Filer" data-i="1">Non Filer</option>
                                </select>
                                <span class="uh"></span>
                            </div>
                            <div class="clearer"></div>
                            <div class="clearer"></div>
                        </div>
                        <div>
                            <button class="pbNext" tabindex="0">Calculate</button>
                        </div>
<!--                        <button class="pbPrevious" tabindex="0">Previous</button>-->

                        <div class="clearer">

                        </div>
                    </fieldset>
                </div>
                <div class= "col-lg-6 pb1 pbreak pbEnd" page="1" style="display:block;">
                    <fieldset>
<!--                        <legend>Page 2 of 2</legend>-->
                        <div class="fields  separator1_1 section_breaks" id="field_1-0">
                            <div class="section_break" id="separator1_1"></div>
                            <h4>Result</h4>
                            <span class="uh"></span>
                            <div class="clearer"></div>
                        </div>
                        <div class="fields  fieldname1_1 cff-calculated-field" id="field_1-5" style="">
                            <label for="fieldname1_1">Total Advance Tax </label>
                            <div class="dfield">
                                <input id="fieldname1_1" name="fieldname1_1" readonly="" class="codepeoplecalculatedfield field medium valid ignorepb" type="text" value="0" dep="" notdep="" aria-invalid="false">
                                <span class="uh"></span>
                            </div>
                            <div class="clearer"></div>
                        </div>
                        <div class="fields  fieldname7_1 cff-calculated-field" id="field_1-6" style="">
                            <label for="fieldname7_1">Total CVT &amp; Stamp Duty </label>
                            <div class="dfield">
                                <input id="fieldname7_1" name="fieldname7_1" readonly="" class="codepeoplecalculatedfield field medium ignorepb" type="text" value="" dep="" notdep="">
                                <span class="uh"></span>
                            </div>
                            <div class="clearer"></div>
                        </div>
<!--                        <div class="fields  fieldname19_1 section_breaks" id="field_1-7">-->
<!--                            <div class="section_break" id="fieldname19_1"></div>-->
<!--                            <label>Total Tax Payable </label>-->
<!--                            <span class="uh"></span>-->
<!--                            <div class="clearer"></div>-->
<!--                        </div>-->
                        <div class="fields  fieldname16_1 cff-calculated-field" id="field_1-8" style="">
                            <label for="fieldname16_1">Grand Total</label>
                            <div class="dfield">
                                <input id="fieldname16_1" name="fieldname16_1" readonly="" class="codepeoplecalculatedfield field medium ignorepb" type="text" value="" dep="" notdep="">
                                <span class="uh"></span>
                            </div>
                            <div class="clearer"></div>
                        </div>
<!--                        <button class="pbPrevious" tabindex="0">Previous</button>-->
<!--                        <button class="pbNext" tabindex="0">Next</button>-->
                        <div class="clearer"></div>
                    </fieldset>
                </div>

            </div>
        </div>
    </div>
</form>