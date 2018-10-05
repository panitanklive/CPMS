import { Component, OnInit } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { Router } from "@angular/router";
import { Location } from "@angular/common";
import { ActivatedRoute } from "@angular/router";
import { CookieService } from "ngx-cookie-service";
import swal from "sweetalert2";
import { UrlService } from "../url.service";
@Component({
  selector: "app-login",
  templateUrl: "./login.component.html",
  styleUrls: ["./login.component.css"]
})
export class LoginComponent implements OnInit {
  get: any;
  user_id = "";
  user_pass = "";
  urlbase: string;

  constructor(
    private http: HttpClient,
    private router: Router,
    private location: Location,
    public service: UrlService,
    private activatedRoute: ActivatedRoute,
    private cookie: CookieService
  ) {
    this.urlbase = service.get_url();
    this.service.nav = "";
  }

  ngOnInit() {}

  loginData() {
    let creds = JSON.stringify({
      user_id: this.user_id,
      user_pass: this.user_pass
    });
   
    this.http
      .post(this.urlbase + "myconn/login", creds, { responseType: "text" })
      .subscribe(data => {
        this.get = data;
        if (this.get == 0) {
          swal({
            type: "error",
            title: "ผิดพลาด",
            text: "ชื่อหรือรหัสผ่านไม่ถูกต้อง!"
          });
        } else if (this.get == 1) {
          swal({
            title: "กำลังเข้าสู่ระบบ!",
            text: "เข้าสู่ระบบสำเร็จเราจะพาคุณไปหน้าเว็บแอปพลิเคชั่น",
            timer: 1000,
            onOpen: () => {
              swal.showLoading();
            }
          }).then(getult => {
            if (
              (this.cookie.set("user_id", this.user_id),
              (this.service.gc = this.user_id),
              this.service.get_cookie(),
              this.router.navigate(["/car"]))
            ) {
            }
          });
        }
      });
  }
}
