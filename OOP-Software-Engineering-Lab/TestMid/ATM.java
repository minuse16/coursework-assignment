import java.util.ArrayList;
import java.util.List;
import java.util.Scanner;

public class ATM {
    static Manager manager;
    static List<Account> accounts = new ArrayList<>();
    static Scanner scanner = new Scanner(System.in);

    public static void main(String[] args) {
        setupManager();

        while (true) {
            System.out.println("\nATM ComputerThanyaburi Bank");
            System.out.println("1. Login as Manager");
            System.out.println("2. Login as Account");
            System.out.println("3. Exit");
            System.out.print("Choose : ");
            int choice = scanner.nextInt();
            scanner.nextLine(); // Clear buffer

            switch (choice) {
                case 1 -> loginManager();
                case 2 -> loginAccount();
                case 3 -> {
                    System.out.println("Thank you for using the service.");
                    return;
                }
                default -> System.out.println("Incorrect choice.");
            }
        }
    }

    static void setupManager() {
        System.out.println("Setup Manager");
        System.out.print("ID Number : ");
        String idNumber = scanner.nextLine();

        System.out.print("Name : ");
        String fullName = scanner.nextLine();

        System.out.print("Gender (Male/Female) : ");
        String gender = scanner.nextLine();

        System.out.print("Password (4 digits) : ");
        String password = scanner.nextLine();

        manager = new Manager(idNumber, fullName, gender, password);
        System.out.println("Manager setup successfully.");
    }

    static void loginManager() {
        System.out.print("ID Number : ");
        String idNumber = scanner.nextLine();

        System.out.print("Password : ");
        String password = scanner.nextLine();

        if (manager.getIdNumber().equals(idNumber) && manager.validatePassword(password)) {
            System.out.println("Login successful. Welcome, " + manager.getFullName());
            managerMenu();
        } else {
            System.out.println("Invalid ID or Password.");
        }
    }

    static void managerMenu() {
        while (true) {
            System.out.println("\nManager Menu");
            System.out.println("1. Add Account");
            System.out.println("2. View All Accounts");
            System.out.println("3. Set BTC Rate");
            System.out.println("4. Logout");
            System.out.print("Choose : ");
            int choice = scanner.nextInt();
            scanner.nextLine(); // Clear buffer

            switch (choice) {
                case 1 -> addAccount();
                case 2 -> viewAccounts();
                case 3 -> {
                    System.out.print("Enter BTC to THB exchange rate : ");
                    double rate = scanner.nextDouble();
                    scanner.nextLine();
                    try {
                        manager.setBtcToThbRate(rate);
                    } catch (IllegalArgumentException e) {
                        System.out.println("Error: " + e.getMessage());
                    }
                }
                case 4 -> {
                    System.out.println("Logging out...");
                    return;
                }
                default -> System.out.println("Incorrect choice.");
            }
        }
    }

    static void addAccount() {
        System.out.print("Enter the number of accounts to add : ");
        int numAccounts = scanner.nextInt();
        scanner.nextLine(); // Clear buffer

        for (int i = 1; i <= numAccounts; i++) {
            System.out.println("\nAdding Account " + i + " of " + numAccounts);
            System.out.print("ID Number : ");
            String idNumber = scanner.nextLine();

            System.out.print("Name : ");
            String fullName = scanner.nextLine();

            System.out.print("Gender (Male/Female) : ");
            String gender = scanner.nextLine();

            System.out.print("Password (4 digits) : ");
            String password = scanner.nextLine();

            System.out.print("Balance : ");
            double balance = scanner.nextDouble();
            scanner.nextLine(); // Clear buffer

            try {
                accounts.add(new Account(idNumber, fullName, gender, password, balance));
                System.out.println("Account " + i + " added successfully.");
            } catch (IllegalArgumentException e) {
                System.out.println("Error: " + e.getMessage());
                i--; // ย้อนกลับไปเพิ่มบัญชีใหม่ในกรณีที่ข้อมูลผิดพลาด
            }
        }
    }

    static void viewAccounts() {
        if (accounts.isEmpty()) {
            System.out.println("No accounts found.");
        } else {
            System.out.println("All Accounts :");
            for (Account account : accounts) {
                System.out.println("ID : " + account.getIdNumber() + ", Name : " + account.getFullName() + 
                                   ", Balance : " + account.getBalance() + " THB");
            }
        }
    }

    static void loginAccount() {
        System.out.print("Account ID Number : ");
        String idNumber = scanner.nextLine();

        System.out.print("Password : ");
        String password = scanner.nextLine();

        for (Account account : accounts) {
            if (account.getIdNumber().equals(idNumber) && account.validatePassword(password)) {
                System.out.println("Login successful. Welcome, " + account.getFullName());
                accountMenu(account);
                return;
            }
        }
        System.out.println("Invalid ID or Password. Please try again.");
    }

    static Account findAccountById(String idNumber) {
        for (Account acc : accounts) {
            if (acc.getIdNumber().equals(idNumber)) {
                return acc;
            }
        }
        return null; // คืนค่า null หากไม่พบบัญชี
    }

    static void accountMenu(Account account) {
        while (true) {
            System.out.println("\nAccount Menu");
            System.out.println("1. Check Balance");
            System.out.println("2. Withdraw Money (THB)");
            System.out.println("3. Withdraw Money (BTC)");
            System.out.println("4. Deposit Money (THB)");
            System.out.println("5. Deposit Money (BTC)");
            System.out.println("6. Transfer Money");
            System.out.println("7. Logout");
            System.out.print("Choose : ");
            int choice = scanner.nextInt();
            scanner.nextLine(); // Clear buffer

            switch (choice) {
                case 1 -> account.checkBalance();
                case 2 -> account.withdrawMoney();
                case 3 -> account.withdrawInBTC(manager.getBtcToThbRate());
                case 4 -> account.depositMoney();
                case 5 -> account.depositInBTC(manager.getBtcToThbRate());
                case 6 -> account.transferMoney();
                case 7 -> {
                    System.out.println("Logging out...");
                    return;
                }
                default -> System.out.println("Incorrect choice.");
            }
        }
    }
}