/**
 *
 * base.js
 *
 */


function openMainDialog(site, theWidth, theHeight, dialogId, modal) {
    if(dialogId==undefined) { dialogId = "dialog"; }
    console.log(modal);
    if($('#'+dialogId).length == 0) { $('body').append($('<div>').attr("id", dialogId));}
    $('#'+dialogId).html('').hide();
    $('#'+dialogId).dialog({ height:(theHeight != undefined ? theHeight : 600), width: (theWidth != undefined ? theWidth : 900), modal: (modal != undefined ? modal : false)});
    $('#'+dialogId).load(site, function() { $('#'+dialogId).show(); });
}

function openAdditionalDialog(dialogName, site, theWidth, theHeight, modal) {
    if($('#'+dialogName).length == 0) { $('body').append($('<div>').attr("id", dialogName));}
    $('#'+dialogName).html('').hide();
    $('#'+dialogName).dialog({ height:(theHeight != undefined ? theHeight : 600), width: (theWidth != undefined ? theWidth : 900), modal: (modal != undefined ? modal : false)});
    $('#'+dialogName).load(site, function() { $('#'+dialogName).show(); });
}

function resizeDialog(theWidth, theHeight) {
    $('#dialog').hide();
    $('#dialog').dialog({ height: theHeight, width: theWidth });
    $('#dialog').show();
}

function getABSHeight(percentage, elementId) {
    var completeHeight = $(window).height();
    if(elementId != undefined) {
        completeHeight = $('#'+elementId).height();
    }
    var absHeight = (completeHeight*(percentage/100)).toFixed(2);
    // console.log("given percentage: " + percentage + " => caclulated: " + absHeight);
    return absHeight;
}

function getABSWidth(percentage, elementId) {
    var completeWidth = $(window).width();
    if(elementId != undefined) {
        completeHeight = $('#'+elementId).height();
    }
    var absWidth = (completeWidth*(percentage/100)).toFixed(2);
    // console.log("given percentage: " + percentage + " => caclulated: " + absWidth);
    return absWidth;
}