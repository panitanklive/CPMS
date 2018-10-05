import { Component, OnInit } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { Router } from "@angular/router";
import { Location } from "@angular/common";
import { ActivatedRoute } from "@angular/router";
import { CookieService } from "ngx-cookie-service";
import swal from "sweetalert2";
import { UrlService } from "../url.service";
@Component({
  selector: "app-header",
  templateUrl: "./header.component.html",
  styleUrls: ["./header.component.css"]
})
export class HeaderComponent implements OnInit {
  get: any[];
  urlbase: string;
  interval: any;
  carback_past: any[] = [{ carpool_id: 0 }];
  cargo_today: any[] = [{ carpool_id: 0 }];

  constructor(
    private http: HttpClient,
    private router: Router,
    private location: Location,
    public service: UrlService,
    private activatedRoute: ActivatedRoute,
    private cookie: CookieService
  ) {
    this.urlbase = service.get_url();
  }
  ngOnInit() {
    this.service.get_cookie();
    this.notification_list();
    this.notification_list2();
    this.send_car();
    this.interval = setInterval(() => {
      this.notification_list2();
      this.notification_list();
      this.send_car();
    }, 3500);
  }

  log_out() {
    this.service.gc = "";
    this.service.del_cookie();
    this.service.ary = [{ name: "ผู้ใช้ทั่วไป", user_level: "0" }];
    swal("เรียบร้อย", "ออกจากระบบเรียบร้อยแล้ว", "success");
  }

  notification_list() {
    this.http
      .get<any[]>(this.urlbase + "myconn/header/notification_list.php")
      .subscribe(data => {
        this.carback_past = data;
      });
  }

  notification_list2() {
    this.http
      .get<any[]>(this.urlbase + "myconn/header/notification_list2.php")
      .subscribe(data => {
        this.cargo_today = data;
      });
  }

  send_car() {
    this.http
      .get<any[]>(this.urlbase + "myconn/header/sendcar.php")
      .subscribe(data => {
        this.get = data;
        if (this.get[0].get != 0) {
        }
      });
  }
}
