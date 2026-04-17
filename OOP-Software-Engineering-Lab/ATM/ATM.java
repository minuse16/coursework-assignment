package ATM;

import java.util.*;

public class ATM {
    private static List<BankAccount> accounts = new ArrayList<>();
    private static Scanner scanner = new Scanner(System.in);

    public static void main(String[] args) {
        initializeAccounts();

        while (true) {
            System.out.println("ATM ComputerThanyaburi Bank");
            System.out.println("1. Login");
            System.out.println("2. Exit");
            System.out.print("Choose : ");
            int choice = scanner.nextInt();
            scanner.nextLine(); // Clear buffer

            switch (choice) {
                case 1 -> login();
                case 2 -> {
                    System.out.println("Thank you for using the service.");
                    return;
                }
                default -> System.out.println("Incorrect choice.");
            }
        }
    }

    private static void initializeAccounts() {
        System.out.print("Enter amount of all account : ");
        int numAccounts = scanner.nextInt();
        scanner.nextLine(); // Clear buffer

        System.out.println("Enter details of each account.");
        for (int i = 1; i <= numAccounts; i++) {
            System.out.println("No. " + i);
            accounts.add(createAccount());
        }
    }

    private static BankAccount createAccount() {
        System.out.print("Account ID (13 digit number) : ");
        String accountNumber = scanner.nextLine();

        System.out.print("Account name (50 characters) : ");
        String accountName = scanner.nextLine();

        System.out.print("Password (4 digit number) : ");
        String password = scanner.nextLine();

        System.out.print("Balance : ");
        double balance;
        try {
            balance = Double.parseDouble(scanner.nextLine());
            if (balance < 0 || balance > 1_000_000) {
                throw new IllegalArgumentException("Balance maximum 1,000,000 baht.");
            }
        } catch (NumberFormatException e) {
            System.out.println("Please enter the correct amount.");
            return createAccount();
        } catch (IllegalArgumentException e) {
            System.out.println(e.getMessage());
            return createAccount();
        }
        System.out.print("\n");

        try {
            return new BankAccount(accountName, accountNumber, password, balance);
        } catch (IllegalArgumentException e) {
            System.out.println("Incorrect information : " + e.getMessage());
            return createAccount();
        }
    }

    private static void login() {
        while (true) {
            System.out.print("Account ID : ");
            String accountNumber = scanner.nextLine();
    
            System.out.print("Password : ");
            String password = scanner.nextLine();
    
            for (BankAccount account : accounts) {
                if (account.getAccountNumber().equals(accountNumber) && account.validatePassword(password)) {
                    System.out.println("Login successfully.");
                    accountMenu(account);
                    return; // ออกจากลูปเมื่อเข้าสู่ระบบสำเร็จ
                }
            }
            System.out.println("Incorrect account number or password. Please try again.\n");
        }
    }
    

    private static void accountMenu(BankAccount account) {
        while (true) {
            System.out.println("\nATM ComputerThanyaburi Bank");
            System.out.println("Account ID : " + account.getAccountNumber());
            System.out.println("Menu Service");
            System.out.println("1. Account Balance");
            System.out.println("2. Withdrawal");
            System.out.println("3. Exit");
            System.out.print("Choose : ");
            int choice = scanner.nextInt();
            scanner.nextLine(); // Clear buffer

            switch (choice) {
                case 1 -> {
                    System.out.println("\nYour balance is: " + account.getBalance() + " THB");
                }
                case 2 -> {
                    System.out.print("\nEnter amount to withdraw : ");
                }
                case 3 -> {
                    System.out.println("\nExit Program.");
                    return;
                }
                default -> System.out.println("Incorrect choice.");
            }
        }
    }
}