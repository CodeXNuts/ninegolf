<!-- Modal -->
<div class="modal fade" id="editLocationModal" tabindex="-1" aria-labelledby="editLocationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editLocationModalLabel">Edit Location</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="locform">
          <div class="row">
            <input type="hidden" name="editModalClubAddress" id="editModalClubAddress" value="">
              <div class="col-lg-6 col-md-6">
                  <div class="form-group">
                      <label for="">Location</label>
                      <input type="text" name="editLocationName" placeholder="Enter Location Name" />
                  </div>
              </div>
              <div class="col-lg-6 col-md-6">
                  <div class="form-group">
                      <label for="">Fee</label>
                      <div class="form_sel">
                          <select id="price" name="editPriceUnit " class="pric editPriceUnit">
                              <option value="cad">CAD</option>
                              <option value="inr">INR</option>
                          </select>
                          <input type="text" name="editPrice" class="pricinput num" />
                      </div>
                  </div>
              </div>
              <div class="col-lg-6 col-md-6">
                  <div class="form-group">
                      <input type="text" id="autocomplete2" name="editAddress" class="autocomplete" placeholder="Enter Address" />
                  </div>
              </div>


          </div>
          <a href="javascript:void(0)" class="btn1 addLocation">Add Locations </a>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary updateThisLoc">Save changes</button>
      </div>
    </div>
  </div>
</div>