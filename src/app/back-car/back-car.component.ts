import { Component, OnInit, ViewChild } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { ActivatedRoute } from "@angular/router";
import swal from "sweetalert2";
import { CookieService } from "ngx-cookie-service";
import { UrlService } from "../url.service";
import { Router } from "@angular/router";
import { Location } from "@angular/common";

@Component({
  selector: "app-back-car",
  templateUrl: "./back-car.component.html",
  styleUrls: ["./back-car.component.css"]
})
export class BackCarComponent implements OnInit {
  urlbase: string;
  trip_mile_end: "";
  trip_mile: any[];
  //trip_mile2 = ""
  trip_id: any;
  oil_price = 0;
  oil_liter = 0;
  oil_net = 0;
  oil: any = [];
  oil_mile: string;
  carpool_id: string;
  //carpool_brand :string
  //carpool_type :string
  get2: any;
  carpool_park: string;
  park: any[] = [
    { carpool_park: "อาคาร 1" },
    { carpool_park: "อาคาร 2" },
    { carpool_park: "อาคาร 3 Scarda" },
    { carpool_park: "อาคาร 5" },
    { carpool_park: "อาคาร 6" },
    { carpool_park: "ลานกว้าง" },
    { carpool_park: "ลานอเนกประสงค์" },
    { carpool_park: "โรงอาหาร" },
    { carpool_park: "สถานีไฟฟ้า" }
  ];

  constructor(
    private http: HttpClient,
    private activatedRoute: ActivatedRoute,
    private cookie: CookieService,
    public service: UrlService,
    private router: Router,
    private location: Location
  ) {
    (this.urlbase = service.get_url()), (this.service.nav = "car");
  }

  ngOnInit() {
    this.activatedRoute.params.subscribe(params => {
      if (!params["key"]) {
      } else {
        this.trip_id = params["key"];
        this.carpool_id = params["car"];
        this.call_mile();
      }
    });
  }

  cal() {
    this.oil_net = this.oil_price * this.oil_liter;
  }

  add() {
    if (this.oil_net == 0 || this.oil_mile == "") {
      swal("ตรวจสอบ", "คุณกรอกข้อมูลไม่ครบถ้วน", "warning");
    } else {
      if (this.oil.length >= 3) {
        swal("ผิดพลาด", "เติมน้ำมันครบ 3 ครั้งแล้ว", "error");
      } else {
        if (this.oil.length == 0) {
          this.oil.push({
            trip_id: this.trip_id,
            oil_mile: this.oil_mile,
            oil_price: this.oil_price,
            oil_liter: this.oil_liter,
            oil_net: this.oil_net
          });
        } else {
          var x = 0;
          for (let i = 0; i < this.oil.length; i++) {
            if (this.oil_mile == this.oil[i].oil_mile) {
              x++;
              swal({
                type: "warning",
                title: "คุณกรอกไมล์ซ้ำ",
                text: "ไมล์ " + this.oil_mile + " อยู่ในรายการแล้ว"
              });
            }
          }
          if (x == 0) {
            this.oil.push({
              trip_id: this.trip_id,
              oil_mile: this.oil_mile,
              oil_price: this.oil_price,
              oil_liter: this.oil_liter,
              oil_net: this.oil_net
            });
          }
        }
      }
      this.oil_price = 0;
      this.oil_liter = 0;
      this.oil_mile = "";
      this.oil_net = 0;
    }
  }

  del(i) {
    this.oil.splice(i, 1);
  }

  get() {
    if (this.trip_mile[0].call == "") {
      swal("ไมล์เดินทาง", "กรุณากรอกไมล์เดินทาง", "warning");
    } else if (this.trip_mile_end == "") {
      swal("ไมล์สิ้นสุด", "กรุณากรอกไมล์สิ้นสุด", "warning");
    } else if (this.carpool_park == "") {
      swal("สถานที่จอดรถ", "กรุณากรอกสถานที่จอดรถ", "warning");
    } else {
      let creds = JSON.stringify({
        trip_id: this.trip_id,
        trip_mile: this.trip_mile[0].call,
        trip_mile_end: this.trip_mile_end,
        carpool_id: this.carpool_id,
        carpool_park: this.carpool_park
      });
      this.http
        .post(this.urlbase + "myconn/give-get/get.php", creds, {
          responseType: "text"
        })
        .subscribe(data => {
          this.get2 = data;
          if (this.get2 == 1) {
            this.save_datail();
          } else if (this.get2 == 2) {
            swal("ยกเลิกการใช้รถ", "ยกเลิกการเดินทางเรียบร้อยแล้ว", "success");
            this.router.navigate(["carpool"]);
          }
        });
    }
  }

  save_datail() {
    let creads = JSON.stringify(this.oil);
    this.http
      .post(this.urlbase + "myconn/give-get/add_detail.php", creads, {
        responseType: "text"
      })
      .subscribe(data => {
        this.get2 = data;
        this.router.navigate(["carpool"]);
        swal({
          title: "เรียบร้อยแล้ว",
          type: "question",
          html:
            "ต้องการตรวจสอบใบจองหรือไม่?, " +
            '<a href="' +
            this.urlbase +
            "\\TCPDF-master\\examples\\take_car.php?&id=" +
            this.trip_id +
            ' "target="_blank">' +
            "คลิกที่นี่" +
            "</a>",
          focusConfirm: false,
          confirmButtonAriaLabel: "ตกลง"
        });
      });
  }

  call_mile() {
    this.http
      .get<any[]>(
        this.urlbase +
          "myconn/give-get/call_mile.php?carpool_id=" +
          this.carpool_id
      )
      .subscribe(data => {
        this.trip_mile = data;
        //this.trip_mile2 = this.trip_mile[0].call
      });
  }

  show(data) {
    this.carpool_park = data;
    swal("สถานที่จอดรถ", "ชื่อสถานที่ : " + data, "success");
  }
}
