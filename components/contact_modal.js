import contactInput from "./contact_input.js";
export default {
    components: { contactInput },
    template: `
        <form id="form1" name="form1" method="post">
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content contact-color">
                        <div class="modal-header">
                            <p class="modal-title fs-6" id="exampleModalLabel" style="font-size: 12px;">聯絡我們</p>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-9 offset-2 ">
                            <contactInput type="text" name="cname" id="cname" placeholder="姓名 Name"></contactInput>
                            <contactInput type="number" name="tel" id="tel" placeholder="連絡電話 TEL"></contactInput>
                            <contactInput type="email" name="email" id="email" placeholder="電子信箱"></contactInput>
                            <contactInput type="text" name="address" id="address" placeholder="聯絡地址 Address"></contactInput>
                            
                            <div class="row mb-3 input-group input-group-sm">
                                <textarea rows="6" class="form-control" name="message" id="message" placeholder="我有話要說 Message" required></textarea>
                                <input type="hidden" name="flag" id="flag" value="form1">
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" name="reset" id="reset" class="btn btn-secondary btn-sm">重填RESET</button>
                        <button type="submit" name="submit" id="submit" class="btn btn-reon-b-y btn-sm">送出SUBMIT</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    `,
}