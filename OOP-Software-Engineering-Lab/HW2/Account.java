package HW2;

import java.util.Scanner;

public class Account extends Person implements ATMAction {
    private String password;
    private double balance;
    Scanner scanner = new Scanner(System.in);

    public Account(String idNumber, String fullName, String gender, String password, double balance) {
        super(idNumber, fullName, gender);
        if (password.length() != 4) {
            throw new IllegalArgumentException("Password must have 4 digits.");
        }
        if (balance < 0) {
            throw new IllegalArgumentException("Balance cannot be negative.");
        }
        this.password = password;
        this.balance = balance;
    }

    public boolean validatePassword(String password) {
        return this.password.equals(password);
    }

    public double getBalance() {
        return balance;
    }

    @Override
    public void checkBalance() {
        System.out.println("Your current balance is : " + balance + " THB");
    }

    @Override
    public void withdrawMoney() {
        System.out.print("Enter amount to withdraw : ");
        double amount = scanner.nextDouble();

        if (amount <= 0) {
            System.out.println("Withdrawal amount must be greater than zero.");
        } else if (amount > balance) {
            System.out.println("Insufficient balance.");
        } else {
            balance -= amount;
            System.out.println("Withdrawal successful. Remaining balance : " + balance);
        }
    }

    @Override
    public void depositMoney() {
        System.out.print("Enter amount to deposit : ");
        double amount = scanner.nextDouble();

        if (amount <= 0) {
            System.out.println("Deposit amount must be greater than zero.");
        } else {
            balance += amount;
            System.out.println("Deposit successful. New balance : " + balance);
        }
    }

    @Override
    public void transferMoney() {
        System.out.print("Enter recipient ID : ");
        String recipientId = scanner.nextLine();
        scanner.nextLine();

        System.out.print("Enter amount to transfer : ");
        while (!scanner.hasNextDouble()) { // ตรวจสอบว่าใส่ตัวเลขหรือไม่
            System.out.println("Invalid amount. Please enter a numeric value.");
            System.out.print("Enter amount to transfer: ");
            scanner.next(); // ข้ามค่าที่ไม่ใช่ตัวเลข
        }
        double amount = scanner.nextDouble();
        scanner.nextLine();

        if (amount <= 0) {
            System.out.println("Transfer amount must be greater than zero.");
            return;
        }
        if (amount > balance) {
            System.out.println("Insufficient balance.");
            return;
        }

        Account recipient = ATM.findAccountById(recipientId);
        if (recipient == null) {
            System.out.println("Recipient account not found.");
            return;
        }

        balance -= amount;
        recipient.receiveMoney(amount); // ใช้เมธอดที่เพิ่มเงินโดยตรง
        System.out.println("Transfer successful. Remaining balance : " + balance);
    }

    public void receiveMoney(double amount) {
        if (amount > 0) {
            balance += amount;
        }
    }

    @Override
    public String toString() {
        return "Account{" +
                "idNumber='" + getIdNumber() + '\'' +
                ", fullName='" + getFullName() + '\'' +
                ", gender='" + getGender() + '\'' +
                ", balance=" + balance +
                '}';
    }
}
