jQuery(document).ready(function ($) {
  var mediaUploader;

  // Upload image button click
  $("#llr_upload_image_button").on("click", function (e) {
    e.preventDefault();

    // If the media uploader already exists, reopen it
    if (mediaUploader) {
      mediaUploader.open();
      return;
    }

    // Create a new media uploader
    mediaUploader = wp.media({
      title: "Select Login Logo",
      button: {
        text: "Use this image",
      },
      multiple: false,
      library: {
        type: "image",
      },
    });

    // When an image is selected
    mediaUploader.on("select", function () {
      var attachment = mediaUploader.state().get("selection").first().toJSON();

      // Set the image ID
      $("#llr_logo_image_id").val(attachment.id);

      // Update the preview
      var imgUrl = attachment.sizes.medium
        ? attachment.sizes.medium.url
        : attachment.url;
      var previewHtml =
        '<img src="' +
        imgUrl +
        '" style="max-width: 300px; height: auto; display: block; margin-bottom: 10px;">';
      $(".llr-image-preview").html(previewHtml);

      // Update button text
      $("#llr_upload_image_button").text("Change Image");

      // Show remove button if not already visible
      if ($("#llr_remove_image_button").length === 0) {
        $("#llr_upload_image_button").after(
          '<button type="button" class="button" id="llr_remove_image_button">Remove Image</button>'
        );
      }
    });

    // Open the media uploader
    mediaUploader.open();
  });

  // Remove image button click (using event delegation since button may not exist on load)
  $(document).on("click", "#llr_remove_image_button", function (e) {
    e.preventDefault();

    // Clear the image ID
    $("#llr_logo_image_id").val("");

    // Clear the preview
    $(".llr-image-preview").html("");

    // Update button text
    $("#llr_upload_image_button").text("Select Image");

    // Remove the remove button
    $(this).remove();
  });
});
