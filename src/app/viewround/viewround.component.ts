import { Component, OnInit, ViewChild } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { ActivatedRoute } from "@angular/router";
import swal from "sweetalert2";
import { CookieService } from "ngx-cookie-service";
import { UrlService } from "../url.service";
import { Router } from "@angular/router";
import { Location } from "@angular/common";

@Component({
  selector: "app-viewround",
  templateUrl: "./viewround.component.html",
  styleUrls: ["./viewround.component.css"]
})
export class ViewroundComponent implements OnInit {
  urlbase: string;
  round: any[];
  passenger: any[];
  trip_id: string;

  constructor(
    private http: HttpClient,
    private activatedRoute: ActivatedRoute,
    private cookie: CookieService,
    public service: UrlService,
    private router: Router,
    private location: Location
  ) {
    (this.urlbase = service.get_url()), (this.service.nav = "round");
  }

  ngOnInit() {
    this.activatedRoute.params.subscribe(params => {
      if (!params["key"]) {
      } else {
        this.trip_id = params["key"];
        this.veiw_round();
        this.feed_passenger();
      }
    });
  }

  veiw_round() {
    this.http
      .get<any[]>(
        this.urlbase + "myconn/round/veiw_round.php?trip_id=" + this.trip_id
      )
      .subscribe(data => {
        this.round = data;
      });
  }

  feed_passenger() {
    this.http
      .get<any[]>(
        this.urlbase + "myconn/round/feed_passenger.php?trip_id=" + this.trip_id
      )
      .subscribe(data => {
        this.passenger = data;
      });
  }

  group_dep(employee_dep) {
    swal({
      title: "ข้อมูลเพิ่มเติม",
      type: "info",
      html: "แผนก : " + employee_dep,
      focusConfirm: false,
      confirmButtonAriaLabel: "ตกลง"
    });
  }
}
