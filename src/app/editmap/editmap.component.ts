import { Component, OnInit, ViewChild } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { ActivatedRoute } from "@angular/router";
import swal from "sweetalert2";
import { CookieService } from "ngx-cookie-service";
import { UrlService } from "../url.service";
import { Router } from "@angular/router";
import { Location } from "@angular/common";

@Component({
  selector: "app-editmap",
  templateUrl: "./editmap.component.html",
  styleUrls: ["./editmap.component.css"]
})
export class EditmapComponent implements OnInit {
  urlbase: string;
  trsg_id: any;
  trsg: any[];
  btnName = "แก้ไข";
  get: any;

  trsg_any = [
    { name: "กรุงเทพฯ" },
    { name: "นครนายก" },
    { name: "ปทุมธานี" },
    { name: "ปราจีนบุรี" },
    { name: "พระนครศรีอยุธยา" },
    { name: "สระแก้ว" },
    { name: "สระบุรี" },
    { name: "อ่างทอง" }
  ];

  constructor(
    private http: HttpClient,
    private activatedRoute: ActivatedRoute,
    private cookie: CookieService,
    public service: UrlService,
    private router: Router,
    private location: Location
  ) {
    (this.urlbase = service.get_url()), (this.service.nav = "map");
  }

  ngOnInit() {
    this.activatedRoute.params.subscribe(params => {
      if (!params["key"]) {
      } else {
        this.trsg_id = params["key"];
        this.feed_trsg();
      }
    });
  }

  feed_trsg() {
    this.http
      .get<any[]>(
        this.urlbase + "myconn/map/feed_trsg.php?trsg_id=" + this.trsg_id
      )
      .subscribe(data => {
        this.trsg = data;
      });
  }

  edit() {
    if (this.trsg[0].trsg_id == "") {
      swal("รหัสสถานที่", "กรุณากรอกรหัสสถานที่", "warning");
    } else if (this.trsg[0].trsg_name == "") {
      swal("ชื่อสถานที่", "กรุณากรอกชื่อสถานที่เดินทาง", "warning");
    } else if (this.trsg[0].trsg_city == "") {
      swal("จังหวัด", "กรุณาเลือกจังหวัด", "warning");
    } else if (this.trsg[0].trsg_map == "") {
      swal("ลิงค์แผนที่", "กรุณากรอกลิงค์แผนที่", "warning");
    } else {
      let creds = JSON.stringify({
        url: this.urlbase,
        trsg_id: this.trsg[0].trsg_id,
        trsg_name: this.trsg[0].trsg_name,
        trsg_city: this.trsg[0].trsg_city,
        trsg_map: this.trsg[0].trsg_map,
        btnName: this.btnName
      });
      this.http
        .post(this.urlbase + "myconn/map/edit_map.php", creds, {
          responseType: "text"
        })
        .subscribe(data => {
          this.get = data;
          if (this.get == 1) {
            swal("เรียบร้อย", "แก้ไขสถานที่เรียบร้อยแล้ว", "success");
            this.router.navigate(["map"]);
          } else {
            swal("เกิดปัญหา", "ไม่สามารถแก้ไขสถานที่ได้", "error");
          }
        });
    }
  }
}
