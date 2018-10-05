import { Component, OnInit } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { Router } from "@angular/router";
import { Location } from "@angular/common";
import { ActivatedRoute } from "@angular/router";
//import { CookieService } from 'angular2-cookie/services/cookies.service';
import { CookieService } from "ngx-cookie-service";
import swal from "sweetalert2";
import { UrlService } from "../url.service";

@Component({
  selector: "app-history",
  templateUrl: "./history.component.html",
  styleUrls: ["./history.component.css"]
})
export class HistoryComponent implements OnInit {
  term = "";
  urlbase: string;
  history: any[] = [{ trip_id: "" }];
  trip_start: "";
  trip_end: "";
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

  ngOnInit() {}

  feed_history() {
    this.http
      .get<any[]>(
        this.urlbase +
          "myconn/round/feed_round2.php?trip_start=" +
          this.trip_start +
          "&&trip_end=" +
          this.trip_end
      )
      .subscribe(data => {
        this.history = data;
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
              this.feed_history();
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
