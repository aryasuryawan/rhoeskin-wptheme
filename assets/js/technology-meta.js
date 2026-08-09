(function($){
  console.log("=== Technology Meta Script Loaded ===");
  
  if (typeof wp === "undefined" || !wp.media) {
    console.error("WP Media not available!");
    return;
  }

  var frame = null, targetRow = null, targetField = null;

  function catIndex() { return Date.now(); }
  function devIndex() { return Date.now() + Math.floor(Math.random() * 10000); }

  // Media picker
  $("#alya-tech-categories").on("click", ".alya-pick", function(e){
    e.preventDefault();
    console.log("Pick clicked");
    targetRow = $(this).closest(".alya-tech-device");
    targetField = $(this).data("field");

    if (frame) { 
      frame.open(); 
      return; 
    }

    frame = wp.media({
      title: "Select Device Image",
      button: { text: "Use This Image" },
      multiple: false
    });

    frame.on("select", function(){
      var att = frame.state().get("selection").first().toJSON();
      if (!targetRow || !targetField) return;
      var url = att.sizes && att.sizes.medium ? att.sizes.medium.url : att.url;
      targetRow.find("input[data-id='" + targetField + "']").val(att.id);
      targetRow.find(".alya-img[data-field='" + targetField + "']").html("<img src='" + url + "' alt=''>");
      console.log("Image set:", att.id);
    });

    frame.open();
  });

  // Clear image
  $("#alya-tech-categories").on("click", ".alya-clear", function(e){
    e.preventDefault();
    console.log("Clear clicked");
    var $row = $(this).closest(".alya-tech-device");
    var field = $(this).data("field");
    $row.find("input[data-id='" + field + "']").val("");
    $row.find(".alya-img[data-field='" + field + "']").html("<span>No image</span>");
  });

  // Add category
  $("#alya-add-category").on("click", function(e){
    e.preventDefault();
    console.log("Add category clicked");
    var tpl = $("#alya-category-tpl").html();
    if (!tpl) {
      console.error("Category template not found!");
      return;
    }
    var idx = catIndex();
    $("#alya-tech-categories").append(tpl.replace(/__CAT_IDX__/g, idx));
    console.log("Category added with index:", idx);
  });

  // Remove category
  $("#alya-tech-categories").on("click", ".alya-remove-cat", function(e){
    e.preventDefault();
    console.log("Remove category clicked");
    var $cats = $("#alya-tech-categories > .alya-tech-category");
    console.log("Total categories:", $cats.length);
    if ($cats.length <= 1) {
      alert("You must have at least one category.");
      return;
    }
    $(this).closest(".alya-tech-category").remove();
    console.log("Category removed");
  });

  // Add device
  $("#alya-tech-categories").on("click", ".alya-add-device", function(e){
    e.preventDefault();
    console.log("Add device clicked");
    var $btn = $(this);
    var catIdx = $btn.data("cat-idx");
    var $container = $btn.closest(".alya-tech-category").find(".alya-tech-devices");
    var tpl = $("#alya-device-tpl").html();
    if (!tpl) {
      console.error("Device template not found!");
      return;
    }
    var idx = devIndex();
    $container.append(tpl.replace(/__CAT_IDX__/g, catIdx).replace(/__DEV_IDX__/g, idx));
    console.log("Device added with index:", idx);
  });

  // Remove device
  $("#alya-tech-categories").on("click", ".alya-remove-dev", function(e){
    e.preventDefault();
    console.log("Remove device clicked");
    var $devices = $(this).closest(".alya-tech-devices");
    if ($devices.children(".alya-tech-device").length <= 1) {
      alert("Each category must have at least one device.");
      return;
    }
    $(this).closest(".alya-tech-device").remove();
    console.log("Device removed");
  });

  // Add feature
  $("#alya-tech-categories").on("click", ".alya-add-feature", function(e){
    e.preventDefault();
    var $btn = $(this);
    var catIdx = $btn.data("cat");
    var devIdx = $btn.data("dev");
    var $container = $btn.prev(".alya-device-features");
    var html = '<div class="alya-feature-row" style="display: flex; gap: 8px; margin-bottom: 6px;">' +
      '<input type="text" name="tech_cat[' + catIdx + '][devices][' + devIdx + '][features][]" value="" placeholder="e.g., Safe & Effective" style="flex: 1;">' +
      '<button type="button" class="button button-small alya-remove-feature">✕</button>' +
      '</div>';
    $container.append(html);
    console.log("Feature added");
  });

  // Remove feature
  $("#alya-tech-categories").on("click", ".alya-remove-feature", function(e){
    e.preventDefault();
    var $container = $(this).closest(".alya-device-features");
    if ($container.children(".alya-feature-row").length <= 1) {
      // Keep at least one empty field
      $(this).closest(".alya-feature-row").find("input").val("");
      return;
    }
    $(this).closest(".alya-feature-row").remove();
    console.log("Feature removed");
  });

  // Add certification
  $("#alya-tech-categories").on("click", ".alya-add-cert", function(e){
    e.preventDefault();
    var $btn = $(this);
    var catIdx = $btn.data("cat");
    var devIdx = $btn.data("dev");
    var $container = $btn.prev(".alya-device-certs");
    var html = '<div class="alya-cert-row" style="display: flex; gap: 8px; margin-bottom: 6px;">' +
      '<input type="text" name="tech_cat[' + catIdx + '][devices][' + devIdx + '][certifications][]" value="" placeholder="e.g., FDA Cleared" style="flex: 1;">' +
      '<button type="button" class="button button-small alya-remove-cert">✕</button>' +
      '</div>';
    $container.append(html);
    console.log("Certification added");
  });

  // Remove certification
  $("#alya-tech-categories").on("click", ".alya-remove-cert", function(e){
    e.preventDefault();
    var $container = $(this).closest(".alya-device-certs");
    if ($container.children(".alya-cert-row").length <= 1) {
      // Keep at least one empty field
      $(this).closest(".alya-cert-row").find("input").val("");
      return;
    }
    $(this).closest(".alya-cert-row").remove();
    console.log("Certification removed");
  });

  // Hero stats - Add
  $("#alya-add-stat").on("click", function(e){
    e.preventDefault();
    console.log("Add stat clicked");
    var tpl = $("#alya-stat-tpl").html();
    if (!tpl) {
      console.error("Stat template not found!");
      return;
    }
    $("#alya-hero-stats").append(tpl.replace(/__STAT_IDX__/g, Date.now()));
    console.log("Stat added");
  });

  // Hero stats - Remove
  $("#alya-hero-stats").on("click", ".alya-remove-stat", function(e){
    e.preventDefault();
    console.log("Remove stat clicked");
    var $stats = $("#alya-hero-stats > .alya-stat-row");
    if ($stats.length <= 1) {
      alert("You must have at least one statistic.");
      return;
    }
    $(this).closest(".alya-stat-row").remove();
    console.log("Stat removed");
  });

  // Certification Logos - Add
  $("#alya-add-cert-logo").on("click", function(e){
    e.preventDefault();
    console.log("Add cert logo clicked");
    var tpl = $("#alya-cert-logo-tpl").html();
    if (!tpl) {
      console.error("Cert logo template not found!");
      return;
    }
    $("#alya-cert-logos").append(tpl.replace(/__LOGO_IDX__/g, Date.now()));
    console.log("Cert logo added");
  });

  // Certification Logos - Remove
  $("#alya-cert-logos").on("click", ".alya-remove-cert-logo", function(e){
    e.preventDefault();
    console.log("Remove cert logo clicked");
    var $logos = $("#alya-cert-logos > .alya-cert-logo-row");
    if ($logos.length <= 1) {
      alert("You must have at least one certification logo.");
      return;
    }
    $(this).closest(".alya-cert-logo-row").remove();
    console.log("Cert logo removed");
  });

  // Certification Logos - Pick image
  $("#alya-cert-logos").on("click", ".alya-pick-cert-logo", function(e){
    e.preventDefault();
    console.log("Pick cert logo clicked");
    targetRow = $(this).closest(".alya-cert-logo-row");
    targetField = $(this).data("field");

    if (frame) { 
      frame.open(); 
      return; 
    }

    frame = wp.media({
      title: "Select Certification Logo",
      button: { text: "Use This Logo" },
      multiple: false
    });

    frame.on("select", function(){
      var att = frame.state().get("selection").first().toJSON();
      if (!targetRow || !targetField) return;
      var url = att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url;
      targetRow.find("input[data-id='" + targetField + "']").val(att.id);
      targetRow.find(".alya-cert-logo-img-preview[data-field='" + targetField + "']").html("<img src='" + url + "' alt=''>");
      console.log("Cert logo image set:", att.id);
    });

    frame.open();
  });

  // Certification Logos - Clear image
  $("#alya-cert-logos").on("click", ".alya-clear-cert-logo", function(e){
    e.preventDefault();
    console.log("Clear cert logo clicked");
    var $row = $(this).closest(".alya-cert-logo-row");
    var field = $(this).data("field");
    $row.find("input[data-id='" + field + "']").val("");
    $row.find(".alya-cert-logo-img-preview[data-field='" + field + "']").html("<span>No logo</span>");
  });

  console.log("All handlers registered");
})(jQuery);
