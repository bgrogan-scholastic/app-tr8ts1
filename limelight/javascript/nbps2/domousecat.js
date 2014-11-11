function doMouseCatButton(cat, name) {
  for (i = 0; i < 14; i++) {
    if (categoryData[i].id == cat)
      catid = categoryData[i].id;
  }

  if (cat != default_cat) {
    leftnavImg.src = imagepath + "nav_left_" + catid + "_" + name + ".gif";
    eval("document.leftnav_" + catid + ".src=leftnavImg.src");  
  }
}
