import { Component, OnInit, ViewChild } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { ActivatedRoute } from "@angular/router";
import swal from "sweetalert2";
import { CookieService } from "ngx-cookie-service";
import { UrlService } from "../url.service";
import { Router } from "@angular/router";
import { Location } from "@angular/common";

@Component({
  selector: "app-editcar",
  templateUrl: "./editcar.component.html",
  styleUrls: ["./editcar.component.css"]
})
export class EditcarComponent implements OnInit {
  urlbase: string;
  carpook_park: any;
  carpool_id: any;
  car: any[];
  get: any;
  car_brand = [
    { brand: "Bmw" },
    { brand: "Chevrolet" },
    { brand: "Ford" },
    { brand: "Honda" },
    { brand: "Isuzu" },
    { brand: "Mazda" },
    { brand: "Mercedez-Benz" },
    { brand: "Mitsubish" },
    { brand: "Nissan" },
    { brand: "Subaru" },
    { brand: "Suzuki" },
    { brand: "Toyota" }
  ];
  park = [
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
        this.carpool_id = params["key"];
        this.feed_car();
      }
    });
  }
  feed_car() {
    this.http
      .get<any[]>(
        this.urlbase + "myconn/car/feed_car2.php?carpool_id=" + this.carpool_id
      )
      .subscribe(data => {
        this.car = data;
      });
  }

  edit() {
    if (this.carpool_id == "") {
      swal("ทะเบียนรถ", "กรุณากรอกทะเบียนรถใหม่", "warning");
    } else if (this.car[0].carpool_brand == "") {
      swal("ยี่ห้อ", "กรุณากรอกยี่ห้อรถ", "warning");
    } else if (this.car[0].carpool_model == "") {
      swal("รุ่น", "กรุณากรอกรุ่นรถ", "warning");
    } else if (this.car[0].carpool_type == "") {
      swal("ประเภทรถ", "กรุณากรอกประเภทรถ", "warning");
    } else if (this.car[0].carpool_sit2 <= 0) {
      swal("จำนวนที่นั่งสูงสุด", "กรุณากรอกที่นั่งสูงสุด", "warning");
    } else if (this.car[0].carpool_mile.length != 6) {
      swal("ไมล์รถ", "กรุณากรอกไมล์รถ", "warning");
    } else if (this.car[0].carpool_park == "") {
      swal("สถานที่จอดรถ", "กรุณากรอกสถานที่จอดรถ", "warning");
    } else {
      let creds = JSON.stringify({
        carpool_id: this.carpool_id,
        carpool_brand: this.car[0].carpool_brand,
        carpool_model: this.car[0].carpool_model,
        carpool_type: this.car[0].carpool_type,
        carpool_sit2: this.car[0].carpool_sit2,
        carpool_mile: this.car[0].carpool_mile,
        carpool_park: this.car[0].carpool_park,
        btnName: "แก้ไข"
      });
      this.http
        .post(this.urlbase + "myconn/car/edit_car.php", creds, {
          responseType: "text"
        })
        .subscribe(data => {
          this.get = data;
          if (this.get == 1) {
            swal(
              "เรียบร้อย",
              "แก้ไข " + this.carpool_id + " เรียบร้อยแล้ว",
              "success"
            );
            this.router.navigate(["car"]);
          } else {
            swal(
              "เกิดปัญหาปัญหา",
              "ไม่สามารถแก้ไข" + " " + this.carpool_id + " ได้",
              "error"
            );
          }
        });
    }
  }
}
