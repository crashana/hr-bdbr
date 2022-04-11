<div class="modal fade" id="candidateModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-right modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="candidateFullName"> ახალი კანდიდატის დამატება</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">

                <div class="col-md-12 row">
                    <div class="col-md-8">
                        <form id="candidateForm">
                            <input type="hidden" name="action" id="candidateAction" value="new">
                            <input type="hidden" name="id" id="candidateId">
                            <div class="form-row col-md-12">

                                <div class="form-group col-md-6">
                                    <label for="candidateFirstName" class="control-label">სახელი</label>
                                    <input type="text" placeholder="სახელი" name="first_name" id="candidateFirstName"
                                           class="form-control" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="candidateLastName" class="control-label">გვარი</label>
                                    <input type="text" placeholder="გვარი" name="last_name" id="candidateLastName"
                                           class="form-control" required>
                                </div>


                                <div class="form-group col-md-12">
                                    <label for="candidatePosition" class="control-label">პოზიცია</label>
                                    <input type="text" placeholder="პოზიცია" name="position" id="candidatePosition"
                                           class="form-control" required>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="candidateSkills" class="control-label">skills</label>
                                    <select name="skills[]" id="candidateSkills" class="form-control"> </select>
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="candidateMinSalary" class="control-label">მინ. ხელფასი</label>
                                    <input type="number" placeholder="მინიმალური ხელფასი" name="min_salary"
                                           id="candidateMinSalary"
                                           class="form-control">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="candidateMaxSalary" class="control-label">მახ. ხელფასი</label>
                                    <input type="number" placeholder="მაქსიმალური ხელფასი" name="max_salary"
                                           id="candidateMaxSalary"
                                           class="form-control">
                                </div>


                                <div class="form-group col-md-12">
                                    <label for="candidateLinkedIn" class="control-label">linkedIn <a class="showLink"
                                                                                                     target="_blank"><i
                                                class="fal fa-link"></i> </a></label>
                                    <input type="url" placeholder="linkedIn url" name="linkedin_url"
                                           id="candidateLinkedIn"
                                           class="form-control">
                                </div>

                                <div class="col-md-12 row">
                                    <div class="form-group col-md-5">
                                        <label for="candidateDocuments" class="control-label">დოკუმენტები</label>
                                        <input type="file" name="documents[]"
                                               id="candidateDocuments"
                                               class="form-control" multiple accept="application/pdf">
                                    </div>

                                    <div class="form-group col-md-7" id="documentsDiv">
                                        <label for="candidateUploadedDocuments" class="control-label">ატვირთული
                                            დოკუმენტები</label>
                                        <ul id="candidateUploadedDocuments">

                                        </ul>
                                    </div>

                                </div>

                            </div>

                            <br>


                            <button type="button" class="btn btn-secondary" data-dismiss="modal">დახურვა</button>
                            <button type="submit" class="btn btn-success">შენახვა</button>
                        </form>

                    </div>
                    <div class="col-md-4 ">
                        <div class="col-md-12" id="changeStatusDiv">
                            <form id="changeStatusForm">
                                <input type="hidden" name="candidate_id" id="changeCandidateId" required>
                                <div class="form-group col-md-12">
                                    <label for="changeStatus" class="control-label">სტატუსი</label>
                                    <select name="status" id="changeStatus"
                                            class="form-control" required>
                                        @foreach($statuses as $status)
                                            <option value="{{$status}}">{{$status}}</option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="form-group col-md-12">
                                    <label for="changeStatusComment" class="control-label">კომენტარი</label>
                                    <textarea name="comment"
                                              id="changeStatusComment"
                                              placeholder="შეიყვანეთ კომენტარი"
                                              class="form-control" required></textarea>

                                </div>

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-xs btn-success">შენახვა</button>


                                </div>

                            </form>
                        </div>
                        <br>

                        <hr style="border:1px solid #0000004d">


                        <div class="col-md-12">
                            <button class="btn btn-xs btn-outline-info" id="currentStatusBtn"></button>
                        </div>
                        <br>

                        <div class="col-md-12 row" id="statusHistory">


                        </div>


                    </div>

                </div>


            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
