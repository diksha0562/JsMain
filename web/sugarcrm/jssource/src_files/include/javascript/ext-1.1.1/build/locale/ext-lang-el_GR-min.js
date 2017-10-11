/*
 * Ext JS Library 1.1.1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */

Ext.UpdateManager.defaults.indicatorText="<div class=\"loading-indicator\">Μεταφό�?τωση δεδομ�νων...</div>";if(Ext.View){Ext.View.prototype.emptyText=""}if(Ext.grid.Grid){Ext.grid.Grid.prototype.ddText="{0} Επιλεγμ�νες σει�?�ς"}if(Ext.TabPanelItem){Ext.TabPanelItem.prototype.closeText="Κλείστε το tab"}if(Ext.form.Field){Ext.form.Field.prototype.invalidText="Το πε�?ιεχόμενο του πεδίου δεν είναι αποδεκτό"}if(Ext.LoadMask){Ext.LoadMask.prototype.msg="Μεταφό�?τωση δεδομ�νων..."}Date.monthNames=["Ιανουά�?ιος","Φεβ�?ουά�?ιος","Μά�?τιος","Απ�?ίλιος","Μάιος","Ιο�?νιος","Ιο�?λιος","Α�?γουστος","Σεπτ�μβ�?ιος","Οκτώβ�?ιος","�?ο�μβ�?ιος","Δεκ�μβ�?ιος"];Date.dayNames=["Κυ�?ιακή","Δευτ��?α","Τ�?ίτη","Τετά�?τη","Π�μπτη","Πα�?ασκευή","Σάββατο"];if(Ext.MessageBox){Ext.MessageBox.buttonText={ok:"OK",cancel:"Άκυ�?ο",yes:"�?αι",no:"Όχι"}}if(Ext.util.Format){Ext.util.Format.date=function(A,B){if(!A){return""}if(!(A instanceof Date)){A=new Date(Date.parse(A))}return A.dateFormat(B||"d/m/Y")}}if(Ext.DatePicker){Ext.apply(Ext.DatePicker.prototype,{todayText:"Σήμε�?α",minText:"Η Ημε�?ομηνία είναι π�?οηγο�?μενη από την παλαιότε�?η αποδεκτή",maxText:"Η Ημε�?ομηνία είναι μεταγεν�στε�?η από την νεότε�?η αποδεκτή",disabledDaysText:"",disabledDatesText:"",monthNames:Date.monthNames,dayNames:Date.dayNames,nextText:"Επόμενος Μήνας (Control+Δεξί Β�λος)",prevText:"Π�?οηγο�?μενος Μήνας (Control + Α�?ιστε�?ό Β�λος)",monthYearText:"Επιλογή Μηνός (Control + Επάνω/Κάτω Β�λος για μεταβολή ετών)",todayTip:"{0} (ΠΛήκτ�?ο Διαστήματος)",format:"d/m/y"})}if(Ext.PagingToolbar){Ext.apply(Ext.PagingToolbar.prototype,{beforePageText:"Σελίδα",afterPageText:"από {0}",firstText:"Π�?ώτη Σελίδα",prevText:"Π�?οηγο�?μενη Σελίδα",nextText:"Επόμενη Σελίδα",lastText:"Τελευταία Σελίδα",refreshText:"Αναν�ωση",displayMsg:"Εμφάνιση {0} - {1} από {2}",emptyMsg:"Δεν υπά�?χουν δεδομ�να"})}if(Ext.form.TextField){Ext.apply(Ext.form.TextField.prototype,{minLengthText:"Το μικ�?ότε�?ο αποδεκτό μήκος για το πεδίο είναι {0}",maxLengthText:"Το μεγαλ�?τε�?ο αποδεκτό μήκος για το πεδίο είναι {0}",blankText:"Το πεδίο �ιναι υποχ�?εωτικό",regexText:"",emptyText:null})}if(Ext.form.NumberField){Ext.apply(Ext.form.NumberField.prototype,{minText:"Η μικ�?ότε�?η τιμή του πεδίου είναι {0}",maxText:"Η μεγαλ�?τε�?η τιμή του πεδίου είναι {0}",nanText:"{0} δεν είναι αποδεκτός α�?ιθμός"})}if(Ext.form.DateField){Ext.apply(Ext.form.DateField.prototype,{disabledDaysText:"Ανενε�?γό",disabledDatesText:"Ανενε�?γό",minText:"Η ημε�?ομηνία αυτο�? του πεδίου π�?�πει να είναι μετά τη {0}",maxText:"Η ημε�?ομηνία αυτο�? του πεδίου π�?�πει να είναι π�?ιν της {0}",invalidText:"{0} δεν είναι �γκυ�?η ημε�?ομηνία - π�?�πει να είναι στη μο�?φή {1}",format:"d/m/y"})}if(Ext.form.ComboBox){Ext.apply(Ext.form.ComboBox.prototype,{loadingText:"Μεταφό�?τωση δεδομ�νων...",valueNotFoundText:undefined})}if(Ext.form.VTypes){Ext.apply(Ext.form.VTypes,{emailText:"Το πεδίο δ�χεται μόνο διευθ�?νσεις Email σε μο�?φή \"user@domain.com\"",urlText:"Το πεδίο δ�χεται μόνο URL σε μο�?φή \"http:/"+"/www.domain.com\"",alphaText:"Το πεδίο δ�χεται μόνο χα�?ακτή�?ες και _",alphanumText:"Το πεδίο δ�χεται μόνο χα�?ακτή�?ες, α�?ιθμο�?ς και _"})}if(Ext.grid.GridView){Ext.apply(Ext.grid.GridView.prototype,{sortAscText:"Α�?ξουσα ταξινόμηση",sortDescText:"Φθίνουσα ταξινόμηση",lockText:"Κλείδωμα στήλης",unlockText:"Ξεκλείδωμα στήλης",columnsText:"Στήλες"})}if(Ext.grid.PropertyColumnModel){Ext.apply(Ext.grid.PropertyColumnModel.prototype,{nameText:"Όνομα",valueText:"Πε�?ιεχόμενο",dateFormat:"m/d/Y"})}if(Ext.SplitLayoutRegion){Ext.apply(Ext.SplitLayoutRegion.prototype,{splitTip:"Τ�?αβήξτε για αλλαγή μεγ�θους.",collapsibleSplitTip:"Τ�?αβήξτε για αλλαγή μεγ�θους. Διπλό κλικ για απόκ�?υψη."})};
