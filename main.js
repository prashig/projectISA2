$(document).ready(function () {
    console.log("jQuery Loaded");

    var classId = $("#classId").val();
    console.log("Debug: classId =", classId);

    if (!classId || classId.trim() === "") {
        $("#message").html("<p style='color: red;'>No Class ID found! Notes may not load properly.</p>");
        return;
    }

    loadNotes();
   

    function loadNotes() {
        $.ajax({
            url: "fetchNotes.php?classId=" + classId,
            type: "GET",
            success: function (response) {
                console.log("Fetch Response:", response);
                try {
                    var data = JSON.parse(response);
                    if (data.success) {
                        let notesHtml = "<h3>Uploaded Notes</h3><ul>";
                        data.notes.forEach(note => {
                            notesHtml += `<li>📄 <a href="${note.path}" download>${note.title}</a></li>`;
                        });
                        notesHtml += "</ul>";
                        $("#notesList").html(notesHtml);
                    } else {
                        $("#notesList").html(`<p style="color: red;">${data.message}</p>`);
                    }
                } catch (error) {
                    console.log("JSON Parse Error:", error);
                    $("#notesList").html('<p style="color: red;">Error loading notes.</p>');
                }
            },
            error: function () {
                console.log("Error fetching notes.");
                $("#notesList").html('<p style="color: red;">Error fetching notes.</p>');
            }
        });
    }

    $('#createClassForm').submit(function (e) {
        e.preventDefault();
        var className = $('#classname').val().trim();
        if (className === "") {
            $('#message').html('<p style="color: red;">Class name cannot be empty!</p>');
            return;
        }
        $.ajax({
            url: 'createClass.php',
            type: 'POST',
            data: { classname: className },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    $('#message').html('<p style="color: green;">' + data.message + '</p>');
                    $('#classname').val('');
                } else {
                    $('#message').html('<p style="color: red;">' + data.message + '</p>');
                }
            },
            error: function () {
                $('#message').html('<p style="color: red;">Error creating class! Please try again.</p>');
            }
        });
    });
});
