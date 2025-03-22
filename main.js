$(document).ready(function () {
    console.log("jQuery Loaded ");
});

$(document).ready(function () {
    var classId = $("#classId").val();
    console.log("Debug: classId =", classId); 

    if (!classId || classId.trim() === "") {
        $("#message").html("<p style='color: red;'> No Class ID found! Notes may not load properly.</p>");
        return; // Stop further execution if no Class ID
    }

    loadNotes(); // Load notes on page load

    //  Handle Note Upload Form Submission
    $("#uploadNoteForm").submit(function (e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        formData.append("classId", classId); // Ensure classId is included

        $.ajax({
            url: "uploadNotes.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(" Upload Response:", response);
                try {
                    var res = JSON.parse(response);
                    if (res.success) {
                        $("#message").html('<p style="color: green;">' + res.message + '</p>');
                        $("#uploadNoteForm")[0].reset();
                        loadNotes(); // Reload notes after successful upload
                    } else {
                        $("#message").html('<p style="color: red;">' + res.message + '</p>');
                    }
                } catch (error) {
                    console.log(" JSON Parse Error:", error);
                }
            },
            error: function () {
                alert(" Upload failed!");
            }
        });
    });

    //  Function to Fetch Notes
    function loadNotes() {
        $.ajax({
            url: "fetchNotes.php?classId=" + classId,
            type: "GET",
            success: function (response) {
                console.log(" Fetch Response:", response);
                try {
                    var data = JSON.parse(response);
                    if (data.success) {
                        let notesHtml = "<h3>Uploaded Notes</h3>";
                        data.notes.forEach(note => {
                            notesHtml += `<p><a href="${note.path}" download>${note.title}</a></p>`;
                        });
                        $("#notesList").html(notesHtml);
                    } else {
                        $("#notesList").html(`<p style="color: red;">${data.message}</p>`);
                    }
                } catch (error) {
                    console.log(" JSON Parse Error:", error);
                }
            },
            error: function () {
                console.log(" Error fetching notes.");
                alert("Error fetching notes.");
            }
        });
    }

    // Handle Class Creation Form Submission
    $('#createClassForm').submit(function (e) {
        e.preventDefault(); // Prevent traditional form submission

        var className = $('#classname').val(); // Get class name

        $.ajax({
            url: 'createClass.php', // File handling class creation
            type: 'POST',
            data: { classname: className },
            success: function (response) {
                console.log(" Class Creation Response:", response);
                try {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        $('#message').html('<p style="color: green;">' + data.message + '</p>');
                        $('#classname').val(''); // Clear input
                    } else {
                        $('#message').html('<p style="color: red;">' + data.message + '</p>');
                    }
                } catch (error) {
                    $('#message').html('<p style="color: red;">Error processing request!</p>');
                    console.log("JSON Parse Error:", error);
                }
            },
            error: function () {
                $('#message').html('<p style="color: red;">Error creating class! Please try again.</p>');
            }
        });
    });
});
