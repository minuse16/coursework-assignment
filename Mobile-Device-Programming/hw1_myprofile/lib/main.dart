import 'package:flutter/material.dart';
import 'package:hw1_myprofile/MyContact.dart';
import 'package:hw1_myprofile/MyEducation.dart';
import 'package:hw1_myprofile/MyHobby.dart';
import 'package:hw1_myprofile/MyProfile.dart';
import 'package:hw1_myprofile/MySkill.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: DefaultTabController(
          length: 5,
          child: Scaffold(
            appBar: AppBar(
              backgroundColor: const Color(0xFFDCABF2),
              title: const Text('My Profile'),
              centerTitle: true,
              bottom: const TabBar(tabs: [
                Tab(
                  icon: Icon(
                    Icons.person_outline,
                  ),
                  text: 'Profile',
                ),
                Tab(
                  icon: Icon(Icons.school_outlined),
                  text: 'Education',
                ),
                Tab(
                  icon: Icon(Icons.desktop_mac_outlined),
                  text: 'Skill',
                ),
                Tab(
                  icon: Icon(Icons.headset_outlined),
                  text: 'Hobbies',
                ),
                Tab(
                  icon: Icon(Icons.call_outlined),
                  text: 'Contact',
                ),
              ]),
            ),
            body: const TabBarView(children: [
              MyProfile(),
              MyEducation(),
              MySkill(),
              MyHobby(),
              MyContact(),
            ]),
          )),
    );
  }
}
