import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class MyContact extends StatelessWidget {
  const MyContact({super.key});

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.center,
        children: [
          Text('\n'),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(
                Icons.call,
                size: 30,
                color: const Color(0xFF1A9214),
              ),
              SizedBox(width: 15),
              Text(
                '095-2501846',
                style:
                    GoogleFonts.mitr(fontSize: 18, fontWeight: FontWeight.w400),
              )
            ],
          ),
          Text('\n'),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(
                Icons.email_rounded,
                size: 30,
                color: const Color(0xFFBB291F),
              ),
              SizedBox(width: 15),
              Text(
                'mintasy94@gmail.com',
                style:
                    GoogleFonts.mitr(fontSize: 18, fontWeight: FontWeight.w400),
              )
            ],
          ),
          Text('\n'),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(
                Icons.location_on_rounded,
                size: 30,
                color: const Color(0xFF0C44B3),
              ),
              SizedBox(width: 15),
              Text(
                '33/2 หมู่1 ต.เขาดินพัฒนา \nอ.เฉลิมพระเกียรติ จ.สระบุรี 18000',
                style:
                    GoogleFonts.mitr(fontSize: 18, fontWeight: FontWeight.w400),
              )
            ],
          )
        ],
      ),
    );
  }
}
