// main loop (page) refresh rate
var ref = 750;
// local store of conversation length
var convoLen = 0;

$(function() {
	if (isLoggedIn()) {

		if (isChatUp()) {
			// refresh chat
			initChat($("#s").val(), $("#p").val(), $("#p").val());
		}

		// main loop
		setInterval(function() { 
			if (isChatUp()) {
				if (isNewChat())
					notify();

				updateChat($("#s").val(), $("#p").val(), $("#p").val());
			}
		}, ref);
	}
});

// make professor aware of new chat; update chat status
function notify() {
	localStorage.setItem("newChat", "0");
	makeSound("../sounds/new_chat.m4a");
}

function updateLastSeen(){
    $.ajax({
        type: "POST",
       	data: {
			id: $("#p").val()
	    },
        url: "../office/updateLastSeen.php"
    });   
}

function makeSound(location) {
	var audio = new Audio(location);
	audio.loop = false;
	audio.play();
}

// replace chat box with newest messages
function updateChat(sentinel, pId, id) {
	$.ajax({
	    url: '../chat/getChat.php',
	    type: "POST",
	    data: {
			sentinel: sentinel,
			pId: pId,
			id: id
	    },
	    success: function(data) {
	    	// if old is shorter than new (new was content added)
	    	if (convoLen != data.length) {
	    		// keep only new content
	    		var lenNew = data.length - convoLen;
	    		var missingMess = data.substring(data.length - lenNew);

	    		// update chat
	    		$('#messages').append(missingMess);

		    	// scroll to bottom of chat
				$('#convo').scrollTop(1E10);

				// update local store of convo length
				convoLen = data.length;
				// newConvoLen(data.length);
			}
	    },
	    error: function() {
	        console.log("Error updating chat");
	    }
	});
}

// replace chat box with newest messages
function initChat(sentinel, pId, id) {
	$.ajax({
	    url: '../chat/getChat.php',
	    type: "POST",
	    data: {
			sentinel: sentinel,
			pId: pId,
			id: id
	    },
	    success: function(data) {
	    	// if old is shorter than new (new was content added)
	    	if (convoLen != data.length) {
	    		// keep only new content
	    		var lenNew = data.length - convoLen;
	    		var missingMess = data.substring(data.length - lenNew);

	    		// initialize chat
	    		$("#messages").html(data);

		    	// scroll to bottom of chat
				$('#convo').scrollTop(1E10);

				// update local store of convo length
				convoLen = data.length;
				// newConvoLen(data.length);
			}
	    },
	    error: function() {
	        console.log("Error updating chat");
	    }
	});
}

function send() {
	officeSend($("#chatInp").val());
}

// actual database insertion
function officeSend(message) {
	// send to db
	$.ajax({
	    url: '../chat/chatSend.php',
	    type: "POST",
	    async: false,
	    data: {
			input: message,
			sentinel: $("#s").val(),
			sender: $("#p").val()
	    },
	    success: function() {
	    	updateLastSeen();
	    },
	    error: function() {
	    	console.log("Error sending");
	    	// officeSend(lastMessage);
	    }
	});
}

function buildNewRoom(pId) {
	var name = prompt("Enter new room name");

	$.ajax({
	    url: '../office/chatInit.php',
	    type: "POST",
	    async: false,
	    data: {
			pId: pId,
			name: name
	    }
	});
	location.reload();
}

function toEmailCard() {
	// default send to address and message
	var to = "";
	var message = 
	"Hi class, I just hopped on Odetta to answer some questions for a bit. "+ 
	"You can ask anything, or see what others have asked here: ";

	$.ajax({
	    url: '../include/getEmailCard.php',
	    type: "POST",
	    async: false,
	    data: {
			to: to,
			message: message
	    },
	    success: function(data) {
	    	// replace invite class card with email card
	    	//$('.email_card').replaceWith(data);
	    	$(".invite_card").replaceWith(data);
	    }
	});
}

function toInviteCard() {
	location.reload();
}

// email constructor
function mail() {
	// get send to address
	var to = $(".em_to").val();
	// get email message
	var message = $(".em_msg").val();

	sendMail(to, message);
}

// send email through Odetta
function sendMail(to, message) {
	$.ajax({
	    url: '../include/mail.php',
	    type: "POST",
	    async: false,
	    data: {
			to: to,
			message: message,
			id: $("#p").val()
	    },
	    error: function() {
	    	console.log("Error mailing");
	    }
	});
}

// return if chatbox is up
function isChatUp() {
	return (typeof $("#s").val() != 'undefined');
}

// determine if chat was just initialized
function isNewChat() {
	return (localStorage.getItem("newChat") == "1");
}

function isLoggedIn() {
	return $("#deacon").length == 0;
}

function logOut() {
	$.post('../include/logOut.php'); 
	location.reload();
}

function chatEnd() {
	window.location.replace("../office");
}