import { Component, OnInit } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { Router } from "@angular/router";
import { Location } from "@angular/common";
import { ActivatedRoute } from "@angular/router";
import { CookieService } from "ngx-cookie-service";
import swal from "sweetalert2";
import { UrlService } from "../url.service";
@Component({
  selector: "app-round",
  templateUrl: "./round.component.html",
  styleUrls: ["./round.component.css"]
})
export class RoundComponent implements OnInit {
  term = "";
  urlbase: string;
  round: any[] = [{ trip_id: "" }];
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
    this.service.nav = "round";
  }

  ngOnInit() {
    this.feed_round();
  }

  feed_round() {
    this.http
      .get<any[]>(this.urlbase + "myconn/round/feed_round.php")
      .subscribe(data => {
        this.round = data;
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
}
