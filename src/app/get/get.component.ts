import { Component, OnInit } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { Router } from "@angular/router";
import { Location } from "@angular/common";
import { ActivatedRoute } from "@angular/router";
import { CookieService } from "ngx-cookie-service";
import swal from "sweetalert2";
import { UrlService } from "../url.service";

@Component({
  selector: "app-get",
  templateUrl: "./get.component.html",
  styleUrls: ["./get.component.css"]
})
export class GetComponent implements OnInit {
  term = "";
  urlbase: string;
  travel: any[] = [{ trip_id: "" }];
  get: any;

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
    this.feed_round();
  }

  feed_round() {
    this.http
      .get<any[]>(this.urlbase + "myconn/round/feed_round1.php")
      .subscribe(data => {
        this.travel = data;
      });
  }

  cancel(data) {
    swal({
      title: "ต้องการยกเลิกการเดินทางหรือไม่",
      text: "คลิกตกลงเพื่อยกเลิกการเดินทาง",
      type: "question",
      showCancelButton: true,
      confirmButtonText: "ok"
    }).then(result => {
      if (result.value) {
        this.http
          .get<any[]>(this.urlbase + "myconn/round/cancel.php?trip_id=" + data)
          .subscribe(data => {
            this.get = data;
            if (this.get == 11) {
              swal("เรียบร้อย", "ยกเลิกการเดินทางเรียบร้อยแล้ว", "success");
              this.feed_round();
            } else {
              swal("เกิดปัญหา", "ไม่สามารถยกเลิกการเดินทางได้", "error");
            }
          });
      } else {
        result.dismiss === swal.DismissReason.cancel;
      }
    });
  }

  async get2(t, c) {
    const { value: name } = await swal({
      title: "กรอกไมล์รถยนต์ปัจจุบัน",
      input: "text",
      inputPlaceholder: "กรอกไมล์รถยนต์ 6 หลัก",
      showCancelButton: true,
      inputValidator: value => {
        return value.length != 6 && "กรุณากรอกไมล์รถยนต์ให้ถูกต้อง!";
      }
    });
    if (name) {
      let creds = JSON.stringify({
        trip_mile_end: name,
        trip_id: t,
        carpool_id: c
      });
      this.http
        .post(this.urlbase + "myconn/give-get/get.php", creds, {
          responseType: "text"
        })
        .subscribe(data => {
          this.get = data;
          if (this.get == 1) {
            swal({ type: "success", title: "รับกุญแจเรียบร้อย" });
            this.router.navigate(["carpool"]);
          } else if (this.get != 1) {
            swal({ type: "error", title: "ไม่รับกุญแจได้" });
          }
        });
      // window.location.reload(true);
    }
  }
}
