import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class MyProfile extends StatelessWidget {
  const MyProfile({super.key});

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      child: Column(
        children: [
          Text('\n'),
          Image.asset(
            'assets/images/profile.jpg',
            width: 250,
            height: 250,
          ),
          Text(
            '\nชื่อ-สกุล : ณัฏฐณิชา สีลาเขตต์\nชื่อเล่น : มิ้นท์\nอายุ : 20 ปี\nวันเกิด : 16 มกราคม 2004\nสัญชาติ : ไทย',
            style: GoogleFonts.mitr(
              fontSize: 18,
              fontWeight: FontWeight.w400,
            ),
          ),
        ],
      ),
    );
  }
}
